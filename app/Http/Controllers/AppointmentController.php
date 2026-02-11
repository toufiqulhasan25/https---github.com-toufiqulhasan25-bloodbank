<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Inventory; // ইনভেন্টরি মডেল যোগ করুন
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function create()
    {
        // হসপিটালের লিস্ট পাঠানো যাতে ডোনার হসপিটাল সিলেক্ট করতে পারে
        $hospitals = \App\Models\User::where('role', 'hospital')->get();
        return view('donor.appointment', compact('hospitals'));
    }

    public function store(Request $r)
    {
        // ১. ভ্যালিডেশন
        $r->validate([
            'hospital_id' => 'required|exists:users,id',
            'donor_name' => 'required|string|max:255',
            'blood_group' => 'required|string|max:10',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
        ]);

        // ২. এলিজিবিলিটি চেক (রিকয়ারমেন্ট: Medical history check)
        // আমরা দেখব গত ৯০ দিনের মধ্যে এই ইউজারের কোনো 'approved' অ্যাপয়েন্টমেন্ট আছে কি না
        $lastDonation = Appointment::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->where('date', '>', Carbon::now()->subDays(90))
            ->latest('date')
            ->first();

        if ($lastDonation) {
            $nextEligibleDate = Carbon::parse($lastDonation->date)->addDays(90)->format('d M, Y');
            return redirect()->back()->with('error', "Eligibility Error: You must wait 90 days between donations. Your next eligible date is {$nextEligibleDate}.");
        }

        // ৩. অ্যাপয়েন্টমেন্ট ক্রিয়েট করা
        Appointment::create([
            'user_id' => Auth::id(),
            'hospital_id' => $r->hospital_id,
            'donor_name' => $r->donor_name,
            'blood_group' => $r->blood_group,
            'date' => $r->date,
            'time' => $r->time,
            'status' => 'pending'
        ]);

        return redirect('/donor/dashboard')->with('success', 'Appointment booked successfully!');
    }

    public function manage()
    {
        // 'hospital_id' এর বদলে 'hospital' হবে (যেটি মডেলে ডিফাইন করা হয়েছে)
        $apps = Appointment::with(['user', 'hospital'])->latest()->get();

        // আপনার ব্লেড ফাইলে যদি ভেরিয়েবল নাম $apps হয়, তবে compact এ 'apps' দিন
        return view('manager.appointments', compact('apps'));
    }

    public function approve($id)
    {
        $app = Appointment::findOrFail($id);

        if ($app->status !== 'pending') {
            return back()->with('error', 'This appointment is already processed.');
        }

        $app->update(['status' => 'approved']);

        // ইনভেন্টরি আপডেট (মডেলের 'units' কলাম ব্যবহার করে)
        $stock = Inventory::where('blood_group', $app->blood_group)->first();

        if ($stock) {
            $stock->increment('units'); // ১ ব্যাগ বাড়াবে
        } else {
            Inventory::create([
                'blood_group' => $app->blood_group,
                'units' => 1,
                'expiry_date' => now()->addDays(42), // সাধারণত রক্ত ৪২ দিন থাকে
            ]);
        }

        return back()->with('success', 'Appointment approved and inventory updated!');
    }
}