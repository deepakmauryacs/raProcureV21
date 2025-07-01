<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function vendor_city()
    {
        return $this->hasOne(Vendor::class, 'city', 'id');
    }
    public function buyer_city()
    {
        return $this->hasOne(Buyer::class, 'city', 'id');
    }
}
