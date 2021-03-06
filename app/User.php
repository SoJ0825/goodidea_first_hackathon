<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;


class User extends Authenticatable {

    use Notifiable;

    public function bag()
    {
        return $this->hasMany('App\Bag');
    }

//    public function boughtCoin($value)
////    {
////        $this->coin += $value;
////        $this->save();
////    }

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
