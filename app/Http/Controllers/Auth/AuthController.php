<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (auth()->check()) {
            return redirect()->back()->with('error', 'Anda sudah login!');
        }
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {
            $user = Auth::user();

            switch ($user->role) {
                case 'Admin':
                    return redirect()->route('dashboard.admin');
                case 'Karyawan':
                    return redirect()->route('dashboard.admin');
                case 'Tim Penilai':
                    return redirect()->route('dashboard.admin');
                case 'Kepala Sekolah':
                    return redirect()->route('dashboard.admin');
                default:
                    Auth::logout();
                    return redirect()->route('view.login')->with('error', 'Role tidak dikenali!');
            }
        }

        return redirect()->back()->with('error', 'Email atau password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('view.login')->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ])->with('success', 'Logout berhasil!');
    }
}
