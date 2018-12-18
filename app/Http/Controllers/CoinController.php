<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GameRecordController;
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

        GameRecordController::gameRecord($request);

        return response(['result' => 'true', 'coin' => $user->coin]);
    }

    public function minusCoin(Request $request)
    {
        $user = User::find(session('id'));
        $user->coin = $user->coin - $request['loss'] < 0 ? 0 : $user->coin - $request['loss'] ;
        $user->save();

        GameRecordController::gameRecord($request);

        return response(['result' => 'true', 'coin' => $user->coin]);
    }
}
