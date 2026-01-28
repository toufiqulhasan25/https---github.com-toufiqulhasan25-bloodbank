<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        'password' => 'required|string|min:6|confirmed',
        'role' => 'required|in:donor,hospital',
        // 'nullable' যোগ করা হয়েছে যেন হসপিটালের ক্ষেত্রে ব্লাড গ্রুপ না দিলেও এরর না দেয়
        'blood_group' => $req->role == 'donor' ? 'required|string' : 'nullable|string',
        'phone' => 'required|string|max:15',
    ]);

    User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role' => $data['role'],
        'blood_group' => $data['blood_group'] ?? null, // ব্লাড গ্রুপ না থাকলে null সেভ হবে
        'phone' => $data['phone'],
    ]);

    return redirect('/login')->with('success', 'Registration successful. Please login.');
}

    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $req)
    {
        $credentials = $req->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $req->session()->regenerate();

            $role = Auth::user()->role;

            // রোল অনুযায়ী সঠিক ড্যাশবোর্ডে পাঠানো
            if ($role === 'manager') {
                return redirect('/manager/dashboard');
            } elseif ($role === 'hospital') {
                return redirect('/hospital/dashboard');
            } else {
                return redirect('/donor/dashboard'); // student/teacher/staff সবাই এই ড্যাশবোর্ডে যাবে
            }
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