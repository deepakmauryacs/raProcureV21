<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_session';

    public $timestamps = false;
    
}
