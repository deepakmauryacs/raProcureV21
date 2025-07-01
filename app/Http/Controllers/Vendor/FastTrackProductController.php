<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\VendorProduct;
use App\Models\User;
use App\Models\Division;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use App\Exports\VerifiedProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class FastTrackProductController extends Controller
{
    public function index($id = null)
    {
        $dealertypes = DB::table('dealer_types')
            ->where('status', '1')
            ->get();
        $uoms = DB::table('uom')
            ->where('status', '1')
            ->get();
        $taxes = DB::table('taxes')
            ->where('status', '1')
            ->get();
        return view('vendor.products.add-fast-track-product', compact('dealertypes', 'uoms', 'taxes', 'id'));
    }

    public function autocomplete(Request $request)
    {
        $search = $request->get('term');
        $vendor_id = getParentUserId();
        $words = preg_split('/\s+/', trim($search)); // Split input by spaces

        $query = DB::table('products')
            ->leftJoin('product_alias', 'product_alias.product_id', '=', 'products.id')
            ->select('products.id', 'products.product_name')
            ->distinct()
            ->limit(100);

        // Add condition to exclude products already associated with the vendor
        if ($vendor_id) {
            $query->whereNotExists(function ($subQuery) use ($vendor_id) {
                $subQuery
                    ->select(DB::raw(1))
                    ->from('vendor_products')
                    ->whereColumn('vendor_products.product_id', 'products.id')
                    ->where('vendor_products.vendor_id', $vendor_id);
            });
        }

        // Search condition for product name or alias
        $query->where(function ($q) use ($words) {
            foreach ($words as $word) {
                $q->where(function ($subQ) use ($word) {
                    $subQ->where('products.product_name', 'like', "%$word%")->orWhere('product_alias.alias', 'like', "%$word%");
                });
            }
        });

        $results = $query->get();

        $response = [];
        foreach ($results as $item) {
            $response[] = [
                'label' => $item->product_name,
                'value' => $item->product_name,
                'id' => $item->id,
            ];
        }

        return response()->json($response);
    }

    public function storeFastTrackProducts(Request $request)
    {
        $validated = $request->validate([
            'products' => 'required|array|min:1',
            'products.*.product_name' => 'required|string|max:255',
            'products.*.ps_desc' => 'required|string|max:500', 
            'products.*.dealer_type' => 'required|exists:dealer_types,id', 
            'products.*.tax_class' => 'required|exists:taxes,id',
            'products.*.ean_code' => 'required|numeric|digits_between:2,8',
            'products.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $createdCount = 0;
        $vendorId = getParentUserId();
        $currentTime = now();

        foreach ($request->products as $rowIndex => $productData) {
            // Handle file upload if exists
            $imagePath = null;
            if ($request->hasFile("products.$rowIndex.image")) {
                $imagePath = $request->file("products.$rowIndex.image")->store('vendor_products', 'public');
            }

            // Determine status based on input
            $status = '1'; // Default active

            if($productData['product_id']){ 
              $editStatus = 3; 
            }else{
              $editStatus = 2; 
            }
         

            // Create vendor product
            DB::table('vendor_products')->insert([
                'vendor_id' => $vendorId,
                'product_id' => $productData['product_id'] ?? null,
                'product_name' => $productData['product_name'],
                'image' => $imagePath,
                'description' => $productData['ps_desc'],
                'dealer_type_id' => $productData['dealer_type'],
                'gst_id' => $productData['tax_class'],
                'hsn_code' => $productData['ean_code'], 
                'vendor_status' => $status,
                'edit_status' => $editStatus,
                'approval_status' => '4',
                'added_by_user_id' => $vendorId,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ]);

            $createdCount++;
        }

        return response()->json([
            'status' => 1,
            'message' => "Successfully created {$createdCount} products",
            'count' => $createdCount,
        ]);
    }

}
