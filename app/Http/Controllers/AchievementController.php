<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Achievement;

class AchievementController extends Controller {

    public function getAchievement(Request $request)
    {
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
}
