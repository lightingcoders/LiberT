<?php

namespace App\Http\Middleware;

use Closure;

class CheckForVerifiedEmail
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
        $error_msg = __("Email verification is required!");

        if($request->user() && !$request->user()->verified){
            return error_response($request, $error_msg);
        }

        return $next($request);
    }
}
