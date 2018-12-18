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

        return response(['result' => 'true', 'response' => $user->coin]);
    }

    public function minusCoin(Request $request)
    {
        $user = User::find(session('id'));
        $user->coin -= $request['loss'];
        $user->save();

        return response(['result' => 'true', 'response' => $user->coin]);
    }

    public function showCoin(Request $request)
    {
        $user = User::find(session('id'));

        return response(['result' => 'true', 'response' => $user->coin]);
    }
}
