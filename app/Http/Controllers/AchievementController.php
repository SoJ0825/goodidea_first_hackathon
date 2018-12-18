<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Achievement;
use Illuminate\Support\Facades\Validator;

class AchievementController extends Controller {

    public function getAchievement(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'achievement' => ['required', 'string', 'regex:(allWin|loss10Time|luckyAce|poorYou|lovelyQueen)'],
                'api_token' => 'required|string|max:32',
                'bool' => 'required|bool',
            ],
            [
                'achievement.regex' => 'The :attribute format is allWin , loss10Time, luckyAce, poorYou or lovelyQueen.',
            ]
        );

        if ($validator->fails())
        {
            return response(['result' => 'false', 'response' => $validator->errors()->first()], 400);
        }
        $achievement = Achievement::select('user_id', $request['achievement'])
            ->where('user_id', session('id'))
//                ->where($request['achievement'], $request['achievement'])
            ->first();

        if ($request['bool'] && $achievement[$request['achievement']] == false)
        {
            Achievement::where('user_id', session('id'))->update([
                $request['achievement'] => $request['bool'],
            ]);

            return response(['result' => 'true', 'response' => 'You get this achievement.']);
        }

        return response(['result' => 'false', 'response' => 'You have this achievement.']);
    }

    public function showAchievement(Request $request)
    {
        $achievement = Achievement::select(
                    'user_id', 'allWin', 'loss10Time', 'luckyAce', 'poorYou', 'lovelyQueen', 'winTwice', 'play10Time')
                        ->where('user_id', session('id'))->first();
        return response(['result' => 'true', 'response' => $achievement]);
    }
}
