<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id'); // 'division_id' is the foreign key
    }

}
