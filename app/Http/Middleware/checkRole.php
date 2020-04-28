<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class checkRole
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
        if(Auth::user()->role != 1)
        {
         return redirect('/home/customer');
        }
        return $next($request);
    }
}
