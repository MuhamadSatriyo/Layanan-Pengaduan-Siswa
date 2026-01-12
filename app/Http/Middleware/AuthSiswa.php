<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthSiswa
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah session siswa ada
        if (!$request->session()->has('siswa_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }

        return $next($request);
    }
}