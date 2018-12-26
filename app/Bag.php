<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bag extends Model {

    protected $fillable = [
        'user_id', 'item_id', 'game_id', 'quantity',
    ];   //

    public function item()
    {
        return $this->belongsTo('App\Item');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
