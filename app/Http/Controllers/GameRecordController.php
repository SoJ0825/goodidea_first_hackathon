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
                $records = AlberRecord::where('user_id', session('id'))->orderBy('created_at', 'desc')->get();
                $results = [];
                foreach ($records as $record)
                {
                    array_push($results, array($record));
                }
                break;
            case 2:
                $records = LesterRecord::where('user_id', session('id'))->orderBy('created_at', 'desc')->get();
                $results = [];
                foreach ($records as $record)
                {
                    array_push($results, array($record));
                }
                break;
            default:
                return response(['result' => 'false', 'response' => "The game doesn\'t exist"]);
        }

        if (count($results) > 0)
        {
            return response(['result' => 'true', 'response' => $results]);
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
            case "Albert":
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
