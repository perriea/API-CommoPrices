<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class midAPI
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
        if (Session::get("username") === NULL) {
            if ($request->ajax()) 
                return response('Unauthorized.', 401);
            else
                return redirect()->guest('/');
        }
        return $next($request);
    }
}
