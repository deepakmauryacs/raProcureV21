<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function state_country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
    public function vendor_state()
    {
        return $this->hasOne(Vendor::class, 'state', 'id');
    }
    public function buyer_state()
    {
        return $this->hasOne(Buyer::class, 'state', 'id');
    }
}
