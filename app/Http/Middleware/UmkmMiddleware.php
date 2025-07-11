<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UmkmMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'umkm') {
            return $next($request);
        }

        abort(403, 'Akses hanya untuk UMKM');
    }
}
