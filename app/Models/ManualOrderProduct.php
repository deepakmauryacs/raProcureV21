<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualOrderProduct extends Model
{
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }
}
