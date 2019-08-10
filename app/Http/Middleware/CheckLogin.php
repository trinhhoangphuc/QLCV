<?php

namespace App\Http\Middleware;

use Closure, Session;

class CheckLogin
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
        if(Session::has("USER_ID"))
            return $next($request);
        else
            return redirect(route('login'));
    }
}
