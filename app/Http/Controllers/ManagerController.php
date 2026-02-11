<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\BloodRequest;
use App\Models\Inventory;
use App\Models\User;

class ManagerController extends Controller
{
    // ১. ম্যানেজার ড্যাশবোর্ড ওভারভিউ
    public function index()
    {
        $data = [
            'total_units' => Inventory::sum('units'), // মোট কত ব্যাগ রক্ত আছে
            'pending_requests' => BloodRequest::where('status', 'pending')->count(),
            'pending_appts' => Appointment::where('status', 'pending')->count(),
            'recent_donors' => Appointment::where('status', 'approved')->latest()->take(5)->get(),
            'inventory' => Inventory::all()
        ];

        return view('manager.dashboard', $data);
    }

    // ২. ইনভেন্টরি বা রক্তের স্টক দেখা
    public function inventory()
    {
        // ১. বর্তমানে স্টকে থাকা মোট এভেলেবল ব্লাড (গ্রুপ অনুযায়ী সাজানো)
        $stockSummary = Inventory::select('blood_group', \DB::raw('SUM(units) as total_units'))
            ->groupBy('blood_group')
            ->get();

        // ২. সকল ইনভেন্টরি ডাটা (টেবিলে দেখানোর জন্য)
        $data = Inventory::latest()->get();

        return view('manager.inventory', compact('data', 'stockSummary'));
    }

    // ৩. ডোনারের অ্যাপয়েন্টমেন্ট অ্যাপ্রুভ করা (স্টক বাড়বে)
    public function approveAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);

        // স্ট্যাটাস আপডেট
        $appointment->update(['status' => 'approved']);

        // ইনভেন্টরিতে রক্ত যোগ করা
        $inventory = Inventory::where('blood_group', $appointment->blood_group)->first();

        if ($inventory) {
            $inventory->increment('stock_count');
        } else {
            Inventory::create([
                'blood_group' => $appointment->blood_group,
                'stock_count' => 1
            ]);
        }

        return back()->with('success', 'Stock updated!');
    }

    // ৪. হসপিটাল ব্লাড রিকোয়েস্ট অ্যাপ্রুভ করা (স্টক কমবে)
    public function approveRequest($id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);

        // স্টক চেক করা
        $stock = Inventory::where('blood_group', $bloodRequest->blood_group)->first();

        if (!$stock || $stock->stock_count < $bloodRequest->units) {
            return back()->with('error', 'Not enough blood in stock to fulfill this request.');
        }

        // রিকোয়েস্ট অ্যাপ্রুভ করা
        $bloodRequest->status = 'approved';
        $bloodRequest->save();

        // ইনভেন্টরি থেকে রক্ত কমিয়ে দেওয়া
        $stock->decrement('stock_count', $bloodRequest->units);

        return back()->with('success', 'Hospital request approved and stock updated!');
    }

    // ৫. রিকোয়েস্ট বা অ্যাপয়েন্টমেন্ট রিজেক্ট করা
    public function rejectRequest($id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        $bloodRequest->status = 'rejected';
        $bloodRequest->save();

        return back()->with('info', 'Request has been rejected.');
    }

    public function reports()
    {
        // ১. মোট রক্তদানের সংখ্যা (Donation statistics)
        // এখানে জয়েন করার প্রয়োজন নেই যদি সবাই সাধারণ ইউজার হয়
        $total_donations = Appointment::where('status', 'approved')->count();

        // ২. কোন গ্রুপের রক্ত কতবার দেওয়া হয়েছে (Blood Group Distribution)
        // এটি ম্যানেজারের জন্য সবচেয়ে গুরুত্বপূর্ণ রিপোর্ট
        $group_reports = Appointment::where('status', 'approved')
            ->select('blood_group', \DB::raw('count(*) as total'))
            ->groupBy('blood_group')
            ->get();

        // ৩. বর্তমান ইনভেন্টরি স্টক (Real-time tracking)
        // ইনভেন্টরিতে কোন গ্রুপের কত ইউনিট আছে
        $inventory_report = Inventory::select('blood_group', \DB::raw('SUM(units) as total_units'))
            ->groupBy('blood_group')
            ->get();

        // ৪. হসপিটাল রিকোয়েস্ট স্ট্যাটাস (Recipient analysis)
        // কতগুলো রিকোয়েস্ট পেন্ডিং বা কমপ্লিট হয়েছে
        $request_stats = BloodRequest::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return view('manager.reports', compact(
            'total_donations',
            'group_reports',
            'inventory_report',
            'request_stats'
        ));
    }


}