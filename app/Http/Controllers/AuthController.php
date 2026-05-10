<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // ─── LOGIN ────────────────────────────────────────────────────────────────

    public function showLogin()
    {
        // Kalau sudah login, langsung redirect sesuai role
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectByRole(Auth::user());
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email atau password salah.']);
    }

    // ─── REGISTER ─────────────────────────────────────────────────────────────

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,   // akan di-hash otomatis via cast
            'role'     => 'pelanggan',           // default, tidak diekspos ke user
        ]);

        // Auto-login setelah daftar
        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/beranda');
    }

    // ─── LOGOUT ───────────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // ─── HELPER ───────────────────────────────────────────────────────────────

    private function redirectByRole(User $user)
    {
        return redirect($user->role === 'admin' ? '/admin/dashboard' : '/beranda');
    }
}
