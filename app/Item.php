<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    public function bag()
    {
        return $this->belongsTo('App\Bag');
    }
}
