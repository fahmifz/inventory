<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->roles === 'staff')) {
          return $next($request); // Hanya admin & staff yang bisa lewat
    }
        return redirect()->route('admin.login')->with('gagal', 'Akses ditolak, bukan admin!');
    
    }
}
