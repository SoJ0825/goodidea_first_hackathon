<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\AlberRecord;
use App\LesterRecord;

class CoinController extends Controller {

    //
    public function addCoin(Request $request)
    {
        $user = User::find(session('id'));
        $user->coin += $request['profit'];
        $user->save();

        $this->gameRecord($request);

        return response(['result' => 'true', 'coin' => $user->coin]);
    }

    public function minusCoin(Request $request)
    {
        $user = User::find(session('id'));
        $user->coin -= $request['loss'];
        $user->save();

        $this->gameRecord($request);

        return response(['result' => 'true', 'coin' => $user->coin]);
    }

    public function showCoin(Request $request)
    {
        $user = User::find(session('id'));

        return response(['result' => 'true', 'response' => $user->coin]);
    }

    public function gameRecord($request)
    {
        $coin = 0;
        if (isset($request['profit']))
        {
            $coin = $request['profit'];
        } elseif (isset($request['loss']))
        {
            $coin = 0 - (int) $request['loss'];
        }
        switch ($request['game'])
        {
            case "Alber":
                AlberRecord::forceCreate([
                    "user_id" => session('id'),
                    "bankroll" => $coin,
                    "type" => $request['type'],
                ]);

                return;
            case "Lester":
                LesterRecord::forceCreate([
                    "user_id" => session('id'),
                    "bankroll" => $coin,
                    "type" => $request['type'],
                ]);

                return;
        }
    }
}
