<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GameRecordController;
use App\Http\Controllers\AchievementController;
use App\User;
use App\AlberRecord;
use App\LesterRecord;
use App\Achievement;

class CoinController extends Controller {

    //
    public function addCoin(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "profit" => "required|integer|min:1|digits_between:0,10"
            ]
        );

        if ($validator->fails())
        {
            $error_message = $validator->errors()->first();

            return response(['result' => 'false', 'error_message' => $error_message]);
        }

        $user = User::find(session('id'));
        $user->coin += $request['profit'];
        $user->save();

        $achievement = Achievement::all()->where('user_id', session('id'))->first();
        $results = ['result'     => 'true',
                    'coin'       => $user->coin,
                    'winTwice'   => $achievement['winTwice'],
                    'play10Time' => $achievement['play10Time']];
        GameRecordController::gameRecord($request);
        if (AchievementController::setWinTwice($request))
        {
            $results['winTwice'] = '1';
        }
        switch ($request['game'])
        {
            case "Albert":
                if (AlberRecord::where('user_id', session('id'))->count() >= 10 && $achievement['play10Time_game1'] == false)
                {
                    Achievement::where('user_id', session('id'))->update([
                        'play10Time_game1' => '1',
                    ]);
                }

            case 'Lester':
                if (LesterRecord::where('user_id', session('id'))->count() >= 10 && $achievement['play10Time_game2'] == false)
                {
                    Achievement::where('user_id', session('id'))->update([
                        'play10Time_game2' => '1',
                    ]);
                }
        }
        if ($achievement['play10Time_game1'] && $achievement['play10Time_game2'])
        {
            Achievement::where('user_id', session('id'))->update([
                'play10Time' => '1',
            ]);
            $results['play10Time'] = '1';
        }

        return response($results);
    }

    public
    function minusCoin(Request $request)
    {
        $user = User::find(session('id'));
        $validator = Validator::make(
            $request->all(),
            [
                "loss" => "required|integer|min:1|max:".$user->coin."|digits_between:0,10"
            ],
            [
                "loss.max" => "You don\'t have enough money."
            ]
        );

        if ($validator->fails())
        {
            $error_message = $validator->errors()->first();

            return response(['result' => 'false', 'error_message' => $error_message]);
        }


        $user->coin = $user->coin - $request['loss'] < 0 ? 0 : $user->coin - $request['loss'];
        $user->save();

        $achievement = Achievement::all()->where('user_id', session('id'))->first();
        $results = ['result'     => 'true',
                    'coin'       => $user->coin,
                    'winTwice'   => $achievement['winTwice'],
                    'play10Time' => $achievement['play10Time']];
        GameRecordController::gameRecord($request);

        switch ($request['game'])
        {
            case "Albert":
                if (AlberRecord::where('user_id', session('id'))->count() >= 10 && $achievement['play10Time_game1'] == false)
                {
                    Achievement::where('user_id', session('id'))->update([
                        'play10Time_game1' => '1',
                    ]);
                }

            case 'Lester':
                if (LesterRecord::where('user_id', session('id'))->count() >= 10 && $achievement['play10Time_game2'] == false)
                {
                    Achievement::where('user_id', session('id'))->update([
                        'play10Time_game2' => '1',
                    ]);
                }
        }
        if ($achievement['play10Time_game1'] && $achievement['play10Time_game2'])
        {
            Achievement::where('user_id', session('id'))->update([
                'play10Time' => '1',
            ]);
            $results['play10Time'] = '1';
        }

        return response($results);
    }

    public
    function showCoin(Request $request)
    {
        $user = User::find(session('id'));
        $achievement = Achievement::all()->where('user_id', session('id'))->first();
        $results = ['result'     => 'true',
                    'coin'       => $user->coin,
                    'winTwice'   => $achievement['winTwice'],
                    'play10Time' => $achievement['play10Time']];

        return response($results);
    }

}
