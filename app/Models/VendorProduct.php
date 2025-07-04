<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorProduct extends Model
{
    protected $table = 'vendor_products';

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id'); 
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Relation to Division through Product
    public function division()
    {
        return $this->product->belongsTo(Division::class, 'division_id');
    }

    // Relation to Category through Product
    public function category()
    {
        return $this->product->belongsTo(Category::class, 'category_id');
    }

    // public function division()
    // {
    //     // Ensure product exists before accessing division
    //     return $this->product ? $this->product->division() : null;
    // }

    // public function category()
    // {
    //     // Ensure product exists before accessing category
    //     return $this->product ? $this->product->category() : null;
    // }

    

    public function productAliases()
    {
        return $this->hasMany(\App\Models\ProductAlias::class, 'product_id', 'product_id');
    }





    public function receivedfrom()
    {
        return $this->belongsTo(User::class, 'added_by_user_id');
    }


    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by_user_id');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function vendor_profile()
    {
        return $this->hasOne(Vendor::class, 'user_id', 'vendor_id');
    }

}
