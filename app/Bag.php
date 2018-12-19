<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bag extends Model {

    //
    public function item()
    {
        return $this->hasMany('App\Item');
    }

    public function user()
    {
        return $this->hasMany('App\User');
    }
}
