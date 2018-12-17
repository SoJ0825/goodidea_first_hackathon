<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Dirape\Token\Token;


class Login {

    public function handle($request, Closure $next, $guard = null)
    {
        $request->validator(
            request(),
            [
                'email' => 'required|string|email',
                'password' => 'required|string|min:6|max:12',
            ]
        );
//        $validator = Validator::make(
//
//            $request->all(),
//
//            [
//                'email' => 'required|string|email',
//                'password' => 'required|string|min:6|max:12',
//            ]
//
//        );
//
//        if ($validator->fails())
//        {
//            $error_message = $validator->errors()->first();
//
//            return response(['results' => 'false', 'response' => $error_message]);
//        }

        $credentials = $request->only('email', 'password');
        if ( ! Auth::attempt($credentials))
        {
            return response(['result' => 'false', 'response' => 'Please check your account or password']);
        }

        $user = $request->user();
        $user->api_token = (new Token())->unique('users', 'api_token', 32);
        $user->save();

        return $next($request);
    }
}
