<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ManualOrder;
use App\Models\Vendor;
class OrderController extends Controller
{
    public function rfqOrder(Request $request) {
       $query = Order::with('order_variants','buyer')->where('vendor_id', getParentUserId());
        
        if ($request->filled('buyer_name'))
        {
            $legal_name=$request->buyer_name;
            $query->whereHas('buyer', function ($q) use ($legal_name) {
                $q->where('legal_name', 'like', "%$legal_name%");
            });
        }
        if ($request->filled('order_no')){
            $query->where('po_number', $request->order_no);
        }
        if ($request->filled('rfq_no')){
            $query->where('rfq_id', $request->rfq_no);
        }
        if ($request->filled('status')){
            $query->where('order_status', $request->status);
        }
        $order=$request->order;
        if (!empty($order)) {
            $query->orderBy($column[$order['0']['column']], $order['0']['dir']);
        } else {
            $query->orderBy('id', 'desc');
        }
        $perPage = $request->input('per_page', 25);
        $results = $query->paginate($perPage)->appends($request->all());
       
        if ($request->ajax()) {
            return view('vendor.order.partials.rfq-table', compact('results'))->render();
        }
        return view('vendor.order.rfq-index',compact('results'));
    }

    public function rfqOrderView(Request $request,$id) {

        $order = Order::with(['order_variants.frq_variant','order_variants.frq_quotation_variant'=>function($q){
             //$q->where('vendor_id', getParentUserId());
        },'buyer'])->where('id', $id)->first();
        return view('vendor.order.rfq-view',compact('order'));
    }

    public function rfqOrderPrint(Request $request,$id) {
       // echo '<pre>';
        $order = Order::with(['vendor','vendor.user','buyer','buyer.users','rfq','rfq.buyer_branchs','order_variants.frq_variant','order_variants.frq_quotation_variant'])->where('id', $id)->first();
       //print_r($order);die;
        return view('vendor.order.rfq-pdf',compact('order'));
    }
    
    public function directOrder(Request $request) {

        $query = ManualOrder::with('order_products','buyer')->where('vendor_id', getParentUserId());
        
        if ($request->filled('buyer_name'))
        {
            $legal_name=$request->buyer_name;
            $query->whereHas('buyer', function ($q) use ($legal_name) {
                $q->where('legal_name', 'like', "%$legal_name%");
            });
        }
        if ($request->filled('order_no')){
            $query->where('manual_po_number', $request->order_no);
        }
        if ($request->filled('status')){
            $query->where('order_status', $request->status);
        }
        $order=$request->order;
        if (!empty($order)) {
            $query->orderBy($column[$order['0']['column']], $order['0']['dir']);
        } else {
            $query->orderBy('id', 'desc');
        }
        $perPage = $request->input('per_page', 25);
        $results = $query->paginate($perPage)->appends($request->all());
       
        if ($request->ajax()) {
            return view('vendor.order.partials.direct-table', compact('results'))->render();
        }
        return view('vendor.order.direct-index', compact('results'));
    }
    
    public function directOrderView(Request $request,$id) {
        
        $order = ManualOrder::with('order_products','order_products.inventory','buyer')->where('id', $id)->first();
        //print_r($order);die;
        return view('vendor.order.direct-view',compact('order'));
    }

    public function directOrderPrint(Request $request,$id) {
        // echo '<pre>';
        $order = ManualOrder::with('order_products','order_products.inventory','buyer')->where('id', $id)->first();
    //    print_r($order->order_products[0]->inventory->branch);die; 
        // print_r($order); 
        $vendor=Vendor::with(['vendor_country','vendor_state','vendor_city'])->where('user_id',getParentUserId())->first();
        // print_r($vendor);die;
        return view('vendor.order.direct-pdf',compact('order','vendor'));
    }
}
