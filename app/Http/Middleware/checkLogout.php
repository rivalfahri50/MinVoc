<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd(Auth::logout());
        // if (Auth::check() && !Auth::logout())
        // {
        // }
        // dd(Auth::logout());
        // if (empty(Auth::user())) {
        //     return back();
        // }
        // dd(Auth::check());
        // if (Auth::check()) {
            return $next($request);
        // }
        // return redirect('/masuk'); 
    }
}
