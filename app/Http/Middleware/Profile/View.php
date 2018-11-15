<?php

namespace App\Http\Middleware\Profile;

use Closure;

class View
{
    /**
     * Handle an incoming request.
     *
     * @param string $name
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->route()->parameter('user');

        if($request->user()->can('view user profile') || $user->id == $request->user()->id){
            return $next($request);
        }

        return abort(403);
    }
}
