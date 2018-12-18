<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AlberRecord;
use App\LesterRecord;

class GameRecordController extends Controller {

    //
    public function show(Request $request, $gameid)
    {
        switch ($gameid)
        {
            case 1:
                $record = AlberRecord::all()->where('user_id', session('id'));
                break;
            case 2:
                $record = LesterRecord::all()->where('user_id', session('id'));
                break;
            default:
                return response(['result' => 'false', 'response' => "The game doesn\'t exist"]);
        }

        if (count($record) > 0)
        {
            return response(['result' => 'true', 'response' => $record]);
        }
        
        return response(['result' => 'false', 'response' => 'no record']);
    }
    
    public static function gameRecord($request)

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
