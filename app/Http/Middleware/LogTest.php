<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogTest {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Log::info('METHOD : ' . $request->method());
        Log::info('PATH : ' . $request->path());
        Log::info($request->header());
        Log::info($request->input());

        $response = $next($request);
//        dd('mi');
        Log::info($response->getContent());
        Log::info('--------------------------------------');

        return $response;
//        return $next($request);
    }
}
