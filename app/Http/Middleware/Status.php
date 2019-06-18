<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Status
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
        if(Auth::check()){
            if(!Auth::user()->status && Auth::user()->role_id == 2){
                Auth::logout();
                return redirect('login')->with('block','Your account is blocked. Please contact with support team.');
            }
        }
        return $next($request);
    }
}
