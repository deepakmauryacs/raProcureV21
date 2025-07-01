<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function latestPlan()
    {
        return $this->hasOne(UserPlan::class,'user_id', 'user_id')->latestOfMany();
    }
    public function vendorVerifiedAt()
    {
        return $this->hasOne(UserPlan::class, 'user_id', 'user_id')->orderBy('id', 'asc');
    }

    public function vendor_products()
    {
        return $this->hasMany(VendorProduct::class, 'vendor_id','user_id');
    }

    public function vendorUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'parent_id');
    }

    public function vendor_country()
    {
        return $this->hasOne(Country::class, 'id', 'country');
    }
    
    public function vendor_state()
    {
        return $this->hasOne(State::class, 'id','state');
    }

    public function vendor_city()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }

}
