<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class CoinController extends Controller {

    //
    public function addCoin(Request $request)
    {
        $user = User::find(session('id'));
        $user->coin += $request['profit'];
        $user->save();
    }
}
