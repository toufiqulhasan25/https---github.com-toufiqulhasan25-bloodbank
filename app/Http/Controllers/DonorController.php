<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DonorController extends Controller
{
    // ডোনার ড্যাশবোর্ড সামারি
    public function index()
    {
        $user = Auth::user();

        // ১. মোট কতবার রক্ত দিয়েছে (Approved Appointments)
        $total_donations = Appointment::where('user_id', $user->id)
            ->where('status', 'approved')
            ->count();

        // ২. সর্বশেষ রক্তদানের তথ্য
        $last_donation = Appointment::where('user_id', $user->id)
            ->where('status', 'approved')
            ->latest('date')
            ->first();

        // ৩. এলিজিবিলিটি ক্যালকুলেশন (৯০ দিনের রুল)
        $isEligible = true;
        $daysUntilNext = 0;
        $nextEligibleDate = null;

        if ($last_donation) {
            $lastDate = Carbon::parse($last_donation->date);
            // diffInDays এর পরিবর্তে diffInMinutes বা সেকেন্ড ব্যবহার করে নিখুঁত গ্যাপ বের করা
            $diffInDays = $lastDate->diffInDays(now(), false);

            if ($diffInDays < 90) {
                $isEligible = false;
                // দশমিক দূর করতে ceil ব্যবহার করুন
                $daysUntilNext = (int) ceil(now()->diffInSeconds($lastDate->copy()->addDays(90)) / 86400);
                $nextEligibleDate = $lastDate->copy()->addDays(90)->format('d M, Y');
            }
        }

        return view('donor.dashboard', compact(
            'total_donations',
            'last_donation',
            'isEligible',
            'daysUntilNext',
            'nextEligibleDate'
        ));
    }

    // ডোনারের রক্তদানের ইতিহাস
    public function history()
    {
        // শুধুমাত্র লগইন করা ইউজারের সকল অ্যাপয়েন্টমেন্ট (Pending, Approved, Rejected)
        $history = Appointment::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('donor.history', compact('history'));
    }
}