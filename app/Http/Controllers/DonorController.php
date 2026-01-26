<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonorController extends Controller
{
    // ডোনার ড্যাশবোর্ড সামারি
    public function index() {
        $user = Auth::user();
        $total_donations = Appointment::where('user_id', $user->id)
                                      ->where('status', 'approved')
                                      ->count();
        
        $last_donation = Appointment::where('user_id', $user->id)
                                     ->where('status', 'approved')
                                     ->latest()
                                     ->first();

        return view('donor.dashboard', compact('total_donations', 'last_donation'));
    }

    // ডোনারের রক্তদানের ইতিহাস
    public function history() {
        // শুধুমাত্র লগইন করা ইউজারের অ্যাপয়েন্টমেন্টগুলো দেখাবে
        $history = Appointment::where('user_id', Auth::id())
                              ->latest()
                              ->get();
                              
        return view('donor.history', compact('history'));
    }
}