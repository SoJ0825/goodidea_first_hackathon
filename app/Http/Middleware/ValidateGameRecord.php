<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;

class ValidateGameRecord {

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
                'game' => ['required', 'string', 'regex:(Albert|Lester)'],
                'type' => 'required|string',
            ]
        );

        if ($validator->fails())
        {
            $error_message = $validator->errors()->first();

            return response(['result' => 'false', 'error_message' => $error_message]);
        }

        return $next($request);
    }
}
