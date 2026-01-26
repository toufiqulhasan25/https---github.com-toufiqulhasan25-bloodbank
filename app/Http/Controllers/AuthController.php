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
        // ভ্যালিডেশনে নতুন ফিল্ডগুলো (user_type, blood_group, phone) যোগ করা হয়েছে
        $data = $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // confirmed দিলে password_confirmation চেক করবে
            'user_type' => 'required|in:donor,hospital,manager', // রোল অনুযায়ী
            'blood_group' => 'nullable|string',
            'phone' => 'required|string|max:15',
        ]);

        // নতুন ডাটা দিয়ে ইউজার তৈরি
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'donor', // ডিফল্টভাবে সবাই 'donor' হিসেবে রেজিস্টার হবে
            'user_type' => $data['user_type'], // student/teacher/staff
            'blood_group' => $data['blood_group'],
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