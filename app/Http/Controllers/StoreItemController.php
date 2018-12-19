<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class StoreItemController extends Controller
{

    public function showStoreItem(Request $request)
    {
        $items = Item::all();
        return response(['result' => 'true', 'response' => $items]);
    }

}
