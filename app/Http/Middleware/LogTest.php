<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogTest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Log::info($request->method(), $request->input(), $request->path());

        $response = $next($request);
//        dd('mi');
        Log::info($response->getContent());
        Log::info('--------------------------------------');
        return $response;
//        return $next($request);
    }
}
