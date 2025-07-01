<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RfqProductVariant extends Model
{
     public function uoms(){
        return $this->belongsTo(Uom::class, 'uom');
    }
}
