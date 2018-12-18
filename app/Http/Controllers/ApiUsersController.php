<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Dirape\Token\Token;
use App\User;

class ApiUsersController extends Controller {

    public function index()
    {
        //
    }

    public function login(Request $request)
    {
        $user = $request->user();

        return response(['result' => 'true',
            'response' => [
                'name' => $user->name,
                'coin' => $user->coin,
                'api_token' => $user->api_token,
            ]]);
    }

    public function logout(Request $request)
    {
            $user = User::find(session('id'));
            $user->api_token = null;
            $user->save();

            return ['result' => 'true', 'response' => 'Logout success'];

    }

    public function store(Request $request)
    {
        $validator = Validator::make(

            $request->all(),

            [
                'name' => 'required|string|max:20',
                'email' => 'unique:users|required|string|email|max:100',
                'password' => 'required|confirmed|string|min:6|max:16',
            ]

        );

        if ($validator->fails())
        {
            $error_message = $validator->errors()->first();

            return response(['result' => 'false', 'response' => $error_message]);
        }

//        dd((new Token())->unique('users', 'api_token', 32));
        User::forceCreate([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'api_token' => (new Token())->unique('users', 'api_token', 32),
            ]
        );
        $user = User::all()->where('email', $request->email)->first();

        return response(['result' => 'true',
            'response' => [
                'name' => $user->name,
                'coin' => $user->coin,
                'api_token' => $user->api_token,
            ]]);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
