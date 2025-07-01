<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchDetail extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

     public function branch_country()
    {
        return $this->hasOne(Country::class, 'id', 'country');
    }
    
    public function branch_state()
    {
        return $this->hasOne(State::class, 'id','state');
    }

    public function branch_city()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }
}
