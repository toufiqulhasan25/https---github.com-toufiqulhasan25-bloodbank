<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Inventory; // ইনভেন্টরি মডেল যোগ করুন
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function create()
    {
        return view('donor.appointment');
    }

    public function store(Request $r)
    {
        // ১. ভ্যালিডেশন
        $r->validate([
            'donor_name' => 'required|string|max:255',
            'blood_group' => 'required|string|max:10',
            'date' => 'required|date|after_or_equal:today', // আজ বা পরের তারিখ হতে হবে
            'time' => 'required',
        ]);

        // ২. ডাটা সেভ (user_id সহ)
        Appointment::create([
            'user_id'     => Auth::id(), // লগইন করা ইউজারের আইডি
            'donor_name'  => $r->donor_name,
            'blood_group' => $r->blood_group,
            'date'        => $r->date,
            'time'        => $r->time,
            'status'      => 'pending'
        ]);

        return redirect('/donor/dashboard')->with('success', 'Appointment booked successfully!');
    }

    public function manage()
    {
        $apps = Appointment::latest()->get(); // লেটেস্ট অ্যাপয়েন্টমেন্ট আগে দেখাবে
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