<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $req)
    {
        $data = $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:donor,hospital,manager',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
        ]);

        // ensure session is fresh and redirect to login with a visible flash
        $req->session()->regenerate();
        return redirect('/login')->with('success', 'Registration successful. Please login.');
    }

    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $req)
    {
        if (Auth::attempt($req->only('email', 'password'))) {
            $req->session()->regenerate();
            $role = Auth::user()->role ?? '';
            // guard: if role not set, send to landing
            if (empty($role)) {
                return redirect('/')->with('error', 'Role not set on account');
            }
            return redirect("/$role/dashboard")->with('success', 'Welcome back!');
        }

        return back()->with('error', 'Invalid credentials')->withInput();
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/')->with('success', 'You have been logged out');
    }
}

