<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

            // Jika user mengakses URL petugas tetapi belum login
            if ($request->is('petugas/*')) {
                return route('petugas.login');
            }

            // Default siswa
            return route('login');
        }
    }
}
