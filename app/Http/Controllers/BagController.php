<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Bag;
use App\Item;


class BagController extends Controller {

    public function buyItem(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'items' => 'required|array',
                'items.*' => 'required|array',
                'items.*.name' => 'required|exists:Items|string',
                'items.*.quantity' => 'required|string',
            ]
        );

        if ($validator->fails())
        {
            $error_message = $validator->errors()->first();

            return response(['result' => 'false', 'response' => $error_message]);
        }
        $results['response'] = [];
        foreach ($request['items'] as $item)
        {

            $merchandise = Item::all()->where('name', $item['name'])->first();
            $user = User::find(session('id'));
            if ($user->coin - ((int) $item['quantity'] * (int) $merchandise['price']) > 0)
            {
                $bag = Bag::updateOrCreate([
                    'user_id' => session('id'),
                    'item_id' => $merchandise['id'],
                ]);
                $bag->increment('quantity', $item['quantity']);

                $user->coin = $user->coin - ((int) $item['quantity'] * (int) $merchandise['price']);
                $user->save();
                $results['result'] = "true";
                array_push($results['response'] , "You buy {$item['quantity']} {$item['name']}");
                continue;
            }
            $results['result'] = "false";
            array_push($results['response'] ,"You have not enough coin");
        }

        return response($results);
    }
}
