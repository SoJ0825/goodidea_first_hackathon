<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;
use App\User;

class CheckApiToken {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'api_token' => 'required|string|max:32',
            ]
        );

        if ($validator->fails())
        {
            $error_message = $validator->errors()->first();

            return response(['result' => 'false', 'response' => $error_message]);
        }

        if ($user = User::all()->where('api_token', $request['api_token'])->first())
        {
            if (time() - $user->token_lifetime < 1200 || $user->token_lifetime == null)
            {
                $user->token_lifetime = time();
                $user->save();
            }

            session()->put('id', $user->id);
            return $next($request);
        }
            return response(['result' => 'false', 'response' => 'User not login']);
    }
}
