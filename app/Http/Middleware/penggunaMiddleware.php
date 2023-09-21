<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class penggunaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->is_login === false) {
            return response()->redirectTo('/masuk');
        } else if (Auth::check() && auth()->user()->role_id === 3) {
            return $next($request);
        }
        return response()->redirectTo('/masuk')->with('message', 'Anda Tidak Mendapatkan Akses Untuk Halaman Ini.');
    }
}
