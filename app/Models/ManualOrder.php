<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualOrder extends Model
{
    //
    public function order_products()
    {
        return $this->hasMany(ManualOrderProduct::class, 'manual_order_id', 'id');
    }

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'user_id');
    }
}
