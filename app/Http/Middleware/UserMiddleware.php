<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;

class UserMiddleware
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

        if (Auth::user()->isUser()) {
            if (Auth::user()->unLocked()) {
                return $next($request);
            } else {
                Auth::logout();
                return redirect('/login')->with(session()->flash('alert-danger', 'Account has been locked'));
            }
        } {
            Auth::logout();
            return redirect('/login')->with(session()->flash('alert-danger', 'Non Permitted link'));
        }
    }
}
