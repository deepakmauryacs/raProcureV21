<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    
    public function vendor_country()
    {
        return $this->hasOne(Vendor::class, 'country', 'id');
    }
    public function buyer_country()
    {
        return $this->hasOne(Buyer::class, 'country', 'id');
    }

}
