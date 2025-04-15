<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
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

    public function showRegister()
    {
        if (auth()->check()) {
            return redirect()->back()->with('error', 'Anda sudah login!');
        }

        return view('pages.auth.register');
    }

    public function register(Request $request)
{
    $data = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|confirmed',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ], [
        'name.required' => "Nama tidak boleh kosong!",
        'email.required' => "Email tidak boleh kosong!",
        'password.required' => "Password tidak boleh kosong!",
        'photo.image' => "File yang diunggah harus berupa gambar!",
        'photo.mimes' => "Format foto harus jpeg, png, atau jpg!",
        'photo.max' => "Ukuran foto maksimal 2MB!",
    ]);

    if ($request->hasFile('photo')) {
        $data['photo'] = $request->file('photo')->store('users', 'public');
    }

    $data['password'] = Hash::make($data['password']);
    $data['role'] = 'Karyawan';

    User::create($data);

    return redirect()->route('view.login')->with('success', 'Berhasil register!');
}
}
