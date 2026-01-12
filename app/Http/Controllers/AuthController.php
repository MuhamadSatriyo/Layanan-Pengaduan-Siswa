<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * FORM LOGIN (SISWA & PETUGAS)
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * PROSES LOGIN (AUTO ROLE)
     */
    public function processLogin(Request $request)
{
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // 🔥 LOGIKA PALING MUDAH
        if (Auth::user()->role === 'petugas') {
            return redirect()->route('petugas.dashboard');
        }

        return redirect()->route('dashboard');
    }

    return back()->with('error', 'Email atau password salah');
    }

    /**
     * FORM REGISTER SISWA
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * PROSES REGISTER SISWA
     */
    public function processRegister(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'nis' => 'required|string|unique:users,nis',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'role' => 'siswa',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /**
     * LOGOUT
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Berhasil logout.');
    }
}
