<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Dirape\Token\Token;


class Login {

    public function handle($request, Closure $next, $guard = null)
    {

        $token_invalid_time = '1200';
        $validator = Validator::make(

            $request->all(),

            [
                'email' => 'required|string|email|max:100',
                'password' => 'required|string|min:6|max:16',
            ]

        );

        if ($validator->fails())
        {
            $error_message = $validator->errors()->first();

            return response(['result' => 'false', 'error_message' => $error_message]);
        }

//        $response = $next($request);
        $credentials = $request->only('email', 'password');
        if ( ! Auth::attempt($credentials))
        {
            return response(['result' => 'false', 'error_message' => 'Please check your account or password']);
        }

        $user = $request->user();

        if (time() - $user->token_lifetime > $token_invalid_time || $user->api_token == null)
        {
            $user->api_token = (new Token())->unique('users', 'api_token', 32);
        }
        $user->token_lifetime = time();
        $user->save();

        return $next($request);
    }
}
