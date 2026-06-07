<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // TAMPIL LOGIN
    public function showLogin()
    {
        return view('auth.login');
    }

    // TAMPIL REGISTER
    public function showRegister()
    {
        return view('auth.register');
    }

    // PROSES REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'user',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/dashboard')->with('success', 'Register berhasil');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah'
        ]);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
