<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class adminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        dd(Auth::check());
        // if (Auth::user()->role_id != 4) {
        //     return back();
        // }
        if (!Auth::check() && Auth::logout() && auth()->user()->is_login === false) {
            return back();
        } else if (Auth::guard('admin')->check() && Auth::user()->role_id == 4) {
            return $next($request);
        }
        return back();
    }
}
