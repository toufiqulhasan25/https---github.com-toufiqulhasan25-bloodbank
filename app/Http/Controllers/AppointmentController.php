<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Inventory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // ১. ডোনারের জন্য বুকিং পেজ ভিউ
    public function create()
    {
        $hospitals = User::where('role', 'hospital')->get();
        return view('donor.appointment', compact('hospitals'));
    }

    // ২. অ্যাপয়েন্টমেন্ট সেভ করা (নোটসহ)
    public function store(Request $r)
    {
        $r->validate([
            'hospital_id' => 'required|exists:users,id',
            'donor_name' => 'required|string|max:255',
            'blood_group' => 'required|string|max:10',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'note' => 'nullable|string|max:500',
        ]);

        // এলিজিবিলিটি চেক
        $lastDonation = Appointment::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->where('date', '>', Carbon::now()->subDays(90))
            ->latest('date')
            ->first();

        if ($lastDonation) {
            $nextEligibleDate = Carbon::parse($lastDonation->date)->addDays(90)->format('d M, Y');
            return redirect()->back()->with('error', "Eligibility Error: Next eligible date is {$nextEligibleDate}.");
        }

        Appointment::create([
            'user_id' => Auth::id(),
            'hospital_id' => $r->hospital_id,
            'donor_name' => $r->donor_name,
            'blood_group' => $r->blood_group,
            'date' => $r->date,
            'time' => $r->time,
            'note' => $r->note,
            'status' => 'pending'
        ]);

        return redirect()->route('donor.dashboard')->with('success', 'Appointment booked successfully!');
    }

    // ৩. হসপিটাল/ম্যানেজারের জন্য অ্যাপয়েন্টমেন্ট লিস্ট দেখা
    public function manage()
    {
        // লজিক: শুধুমাত্র লগইন করা হসপিটালের অ্যাপয়েন্টমেন্টগুলো দেখাবে
        $apps = Appointment::with(['user', 'hospital'])
            ->where('hospital_id', Auth::id()) 
            ->latest()
            ->get();

        return view('manager.appointments', compact('apps'));
    }

    // ৪. অ্যাপয়েন্টমেন্ট অ্যাপ্রুভ এবং ইনভেন্টরি আপডেট
    public function approve($id)
    {
        $app = Appointment::findOrFail($id);

        if ($app->status !== 'pending') {
            return back()->with('error', 'This appointment is already processed.');
        }

        $app->update(['status' => 'approved']);

        // ইনভেন্টরি আপডেট
        $stock = Inventory::where('blood_group', $app->blood_group)
                          ->where('hospital_id', Auth::id()) // বর্তমান হসপিটালের স্টক
                          ->first();

        if ($stock) {
            $stock->increment('units');
        } else {
            Inventory::create([
                'hospital_id' => Auth::id(),
                'blood_group' => $app->blood_group,
                'units' => 1,
                'expiry_date' => now()->addDays(42), 
            ]);
        }

        return back()->with('success', 'Appointment approved and inventory updated!');
    }

    // ৫. ডোনারের জন্য সিঙ্গেল অ্যাপয়েন্টমেন্ট ডিটেইলস
    public function show($id)
    {
        $appointment = Appointment::with('hospital')->where('user_id', Auth::id())->findOrFail($id);
        return view('donor.appointment_details', compact('appointment'));
    }
}