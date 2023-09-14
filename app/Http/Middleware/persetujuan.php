<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class persetujuan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $statusPersetujuan = Cache::put('status_persetujuan_' . auth()->user()->id, 'belum_disetujui', now()->addHours(24));
        if ($statusPersetujuan == 'disetujui') {
            return redirect()->route('artist-verified.kolaborasi');
        } else {
            return $next($request);
        }
    }
}
