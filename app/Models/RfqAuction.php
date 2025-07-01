<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RfqAuction extends Model
{
    //
    public function rfq()
    {
        return $this->belongsTo(Rfq::class,'rfq_no','rfq_id');
    }
    public function rfq_auction_variant()
    {
        return $this->belongsTo(RfqAuctionVariant::class,'id','auction_id');
    }
    public function rfq_vendor_auction()
    {
        return $this->belongsTo(RfqVendorAuction::class,'id','auction_id');
    }
    public function buyer()
    {
        return $this->belongsTo(Buyer::class,'buyer_id','user_id');
    }
}
