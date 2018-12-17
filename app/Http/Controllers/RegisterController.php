<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller {

    //
    public function store(Request $request)
    {

        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|max:12|confirmed',
            ]
        );

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return redirect('/');
    }
}
