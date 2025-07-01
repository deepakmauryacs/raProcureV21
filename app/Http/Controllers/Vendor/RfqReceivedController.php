<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rfq;
class RfqReceivedController extends Controller
{
    public function index(Request $request)
    {
        $query = Rfq::join('rfq_vendors', 'rfqs.rfq_id', '=', 'rfq_vendors.rfq_id')
        ->where('rfq_vendors.vendor_user_id', getParentUserId())
        ->with([
            'rfqVendors',
            'rfqProducts',
            'rfqProducts.masterProduct',
            'buyer'
        ]);
        if ($request->filled('buyer_name'))
        {
            $legal_name=$request->buyer_name;
            $query->whereHas('buyer', function ($q) use ($legal_name) {
                $q->where('legal_name', 'like', "%$legal_name%");
            });
        }
        if ($request->filled('frq_no')){
            $query->where('rfqs.rfq_id', $request->frq_no);
        }
        
        if ($request->filled('status')){
            $query->where('rfq_vendors.vendor_status', $request->status);
        }
        $order=$request->order;
        if (!empty($order)) {
            $query->orderBy($column[$order['0']['column']], $order['0']['dir']);
        } else {
            $query->orderBy('rfqs.id', 'desc');
        }
        $perPage = $request->input('per_page', 25);
        $results = $query->paginate($perPage)->appends($request->all());
        
        if ($request->ajax()) {
            return view('vendor.rfq-received.partials.table', compact('results'))->render();
        }
        return view('vendor.rfq-received.index', compact('results'));
    }
}
