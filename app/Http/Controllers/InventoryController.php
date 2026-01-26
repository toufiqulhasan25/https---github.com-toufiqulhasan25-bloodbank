<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    // ১. ইনভেন্টরি লিস্ট দেখানো
    public function index() {
        $data = Inventory::all(); // ভেরিয়েবলের নাম $data দিন
        return view('manager.inventory', compact('data'));
    }

    // ২. ম্যানুয়ালি স্টক অ্যাড করার জন্য (যেটি আপনার এরর দিচ্ছিল)
    public function store(Request $r) {
        $r->validate([
            'blood_group' => 'required',
            'units' => 'required|integer|min:1',
            'expiry_date' => 'required|date',
        ]);

        $stock = Inventory::where('blood_group', $r->blood_group)->first();

        if ($stock) {
            $stock->increment('units', $r->units); // units কলাম ব্যবহার করুন
            $stock->update(['expiry_date' => $r->expiry_date]);
        } else {
            Inventory::create([
                'blood_group' => $r->blood_group,
                'units' => $r->units,
                'expiry_date' => $r->expiry_date
            ]);
        }

        return back()->with('success', 'Stock added successfully!');
    }

    // ৩. ডোনারের অ্যাপয়েন্টমেন্ট অ্যাপ্রুভ করলে স্টক বাড়বে
    public function approveAppointment($id) {
        $appointment = Appointment::findOrFail($id);
        
        if($appointment->status === 'approved') {
            return back()->with('error', 'Already approved!');
        }

        $appointment->status = 'approved';
        $appointment->save();

        // ইনভেন্টরি আপডেট
        $stock = Inventory::where('blood_group', $appointment->blood_group)->first();
        
        if ($stock) {
            $stock->increment('units'); // stock_count এর বদলে units হবে
        } else {
            Inventory::create([
                'blood_group' => $appointment->blood_group,
                'units' => 1,
                'expiry_date' => now()->addDays(42) // ডিফল্ট এক্সপায়ারি
            ]);
        }

        return back()->with('success', 'Stock updated and Appointment Approved!');
    }

    // ৪. এক্সপায়ারি অ্যালার্ট দেখার জন্য
    public function expiryAlerts() {
        // যে রক্তগুলোর মেয়াদ শেষ বা ৭ দিনের মধ্যে শেষ হবে
        $expired = Inventory::where('expiry_date', '<=', now()->addDays(7))->get();
        return view('manager.expiry_alerts', compact('expired'));
    }
}