<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment; // যদি অ্যাপয়েন্টমেন্ট দেখাতে চান
use Illuminate\Support\Facades\Auth;

class HospitalController extends Controller
{
    // এই index মেথডটি না থাকার কারণেই এরর আসছিল
    public function index() 
    {
        $user = Auth::user();
        
        // এখানে আপনি হাসপাতালের জন্য প্রয়োজনীয় ডাটা তুলে আনতে পারেন
        // উদাহরণস্বরূপ: এই হাসপাতালের কাছে আসা ব্লাড রিকোয়েস্টের সংখ্যা
        return view('hospital.dashboard', compact('user'));
    }
}