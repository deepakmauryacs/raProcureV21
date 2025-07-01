<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rfq extends Model
{
    public function rfqBuyer()
    {
        return $this->belongsTo(User::class, 'id', 'buyer_id');
    }
    public function rfqProducts()
    {
        return $this->hasMany(RfqProduct::class, 'rfq_id', 'rfq_id');
    }
    public function rfqVendors()
    {
        return $this->hasMany(RfqVendor::class, 'rfq_id', 'rfq_id');
    } 
    public function rfqVendorQuotations()
    {
        return $this->hasMany(RfqVendorQuotation::class, 'rfq_id', 'rfq_id');
    } 
    public function buyerUser() {
        return $this->belongsTo(User::class, 'buyer_user_id');
    }
    public function buyerBranch() {
        return $this->belongsTo(BranchDetail::class, 'buyer_branch', 'branch_id');
    }
    public function buyer() {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'user_id');
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vend_id');
    }
    public function products()
    {
        return $this->hasMany(RfqProduct::class, 'rfq_id', 'rfq_id');
    }

    public function buyer_branchs()
    {
        return $this->belongsTo(BranchDetail::class, 'buyer_branch','branch_id');
    }
    
    public function rfq_generated_by()
    {
        return $this->belongsTo(User::class, 'buyer_user_id', 'id');
    }


}
