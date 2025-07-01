<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Buyer extends Model
{
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function latestPlan()
    {
        return $this->hasOne(UserPlan::class,'user_id', 'user_id')->latestOfMany();
    }
    public function buyerVerifiedAt()
    {
        return $this->hasOne(UserPlan::class, 'user_id', 'user_id')->orderBy('id', 'asc');
    }
    
    public function buyerUser()
    {
        return $this->hasMany(User::class, 'parent_id', 'user_id');
        //return $this->belongsTo(User::class, 'user_id', 'parent_id');
    }

    public function rfqs()
    {
        return $this->hasMany(Rfq::class, 'buyer_id', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id', 'user_id');
    }

    public function getLastLoginDate($userId)
    {
        $lastLogin = DB::table('user_session')
            ->where('user_id', $userId)
            ->max('updated_date');

        if (!empty($lastLogin) && $lastLogin !== '0000-00-00 00:00:00') {
            return date('d/m/Y', strtotime($lastLogin));
        }

        return '-';
    }

    public function buyer_country()
    {
        return $this->hasOne(Country::class, 'id', 'country');
    }
    
    public function buyer_state()
    {
        return $this->hasOne(State::class, 'id','state');
    }

    public function buyer_city()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }
}

