<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserMiddleware
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->tokenCan('role:User')|| auth()->user()->tokenCan('role:Moderator') || auth()->user()->tokenCan('role:Admin')) {
            return $next($request);
        }

        return response()->json('Not Authorized, User Middleware', 401);
    }
}
