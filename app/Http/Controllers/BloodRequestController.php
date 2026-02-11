<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BloodRequestController extends Controller
{
    public function create()
    {
        // ভিউ ফাইলের নাম আপনার ফোল্ডার অনুযায়ী 'hospital.request_blood' হতে পারে
        return view('hospital.request_blood');
    }

    public function store(Request $r)
    {
        Log::info('BloodRequest store called', ['user_id' => Auth::id()]);
        
        $data = $r->validate([
            'patient_name' => 'required|string|max:255',
            'blood_group'  => 'required|string|max:10',
            'bags_needed'  => 'required|integer|min:1',
            'phone'        => 'required|string',
            'location'     => 'required|string',
            'reason'       => 'nullable|string',
        ]);

        // ডাটাবেস কলাম অনুযায়ী ডাটা ম্যাপ করা
        BloodRequest::create([
            'hospital_id'  => Auth::id(),
            'patient_name' => $data['patient_name'],
            'blood_group'  => $data['blood_group'],
            'bags_needed'  => $data['bags_needed'],
            'phone'        => $data['phone'],
            'location'     => $data['location'],
            'reason'       => $data['reason'],
            'status'       => 'pending',
        ]);
        
        return redirect('/hospital/dashboard')->with('success', 'Blood request submitted successfully');
    }

    public function manage()
    {
        // ম্যানেজার সব রিকোয়েস্ট দেখতে পারবে
        $requests = BloodRequest::with('hospital')->latest()->get();
        return view('manager.requests', compact('requests'));
    }

    public function approve($id)
{
    $req = BloodRequest::findOrFail($id);

    // ১. অলরেডি প্রসেসড কি না চেক
    if ($req->status !== 'pending') {
        return back()->with('error', 'This request has already been processed.');
    }

    // ট্রানজেকশন শুরু যাতে ডাটাবেস এরর না হয়
    return DB::transaction(function () use ($req) {
        
        // ২. ইনভেন্টরি চেক (শুধুমাত্র যেগুলো এক্সপায়ার হয়নি এবং এভেলেবল আছে)
        $totalAvailable = Inventory::where('blood_group', $req->blood_group)
                            ->where('expiry_date', '>', now()) // Expiration Tracking
                            ->sum('units');

        // ৩. পর্যাপ্ত স্টক চেক করা
        if ($totalAvailable < $req->bags_needed) {
            return back()->with('error', "Insufficient fresh stock! Available: {$totalAvailable} units.");
        }

        // ৪. স্টক কমানো (FIFO - First In First Out পদ্ধতিতে কমানো ভালো যাতে পুরনো রক্ত আগে বিলি হয়)
        $needed = $req->bags_needed;
        $items = Inventory::where('blood_group', $req->blood_group)
                            ->where('expiry_date', '>', now())
                            ->orderBy('expiry_date', 'asc') // দ্রুত এক্সপায়ার হবে এমনগুলো আগে বের করা
                            ->get();

        foreach ($items as $item) {
            if ($needed <= 0) break;

            if ($item->units <= $needed) {
                $needed -= $item->units;
                $item->decrement('units', $item->units);
                $item->update(['status' => 'dispatched']); // স্ট্যাটাস ট্র্যাকিং
            } else {
                $item->decrement('units', $needed);
                $needed = 0;
            }
        }

        // ৫. রিকোয়েস্ট আপডেট করা (Issue blood units and track distribution)
        $req->update([
            'status' => 'approved',
            'approved_at' => now()
        ]);

        return back()->with('success', 'Blood units issued successfully and inventory updated.');
    });
}

    public function reject($id)
    {
        $req = BloodRequest::findOrFail($id);
        $req->update(['status' => 'rejected']);
        return back()->with('success', 'Request rejected.');
    }

    public function history()
{
    // বর্তমান লগইন করা হসপিটালের সব রিকোয়েস্ট দেখা যাবে
    $requests = BloodRequest::where('hospital_id', Auth::id())
                ->latest()
                ->paginate(10);

    return view('hospital.history', compact('requests'));
}
}