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
        return view('hospital.request');
    }

    public function store(Request $r)
    {
        Log::info('BloodRequest store called', ['user_id' => Auth::id()]);
        
        $data = $r->validate([
            'hospital_name' => 'required|string|max:255',
            'blood_group'   => 'required|string|max:10',
            'units'         => 'required|integer|min:1',
        ]);

        // রিকোয়েস্টের সাথে লগইন করা ইউজারের আইডি সেভ করা
        $data['user_id'] = Auth::id(); 
        $data['status'] = 'pending';

        BloodRequest::create($data);
        
        return redirect('/hospital/dashboard')->with('success', 'Blood request submitted successfully');
    }

    public function manage()
    {
        // সব রিকোয়েস্ট লেটেস্ট অনুযায়ী দেখাবে
        $requests = BloodRequest::latest()->get();
        return view('manager.requests', compact('requests'));
    }

    public function approve($id)
    {
        $req = BloodRequest::findOrFail($id);

        if ($req->status !== 'pending') {
            return back()->with('error', 'Request is already processed.');
        }

        // DB Transaction ব্যবহার করে স্টক কমানোর লজিক
        return DB::transaction(function () use ($req) {
            $inv = Inventory::where('blood_group', $req->blood_group)
                            ->lockForUpdate()
                            ->first();

            if (!$inv) {
                return back()->with('error', "No inventory found for Group: {$req->blood_group}");
            }

            if ($inv->units < $req->units) {
                return back()->with('error', 'Inventory stock is insufficient for this request.');
            }

            // ১. রিকোয়েস্ট অ্যাপ্রুভ করা
            $req->update(['status' => 'approved']);
            
            // ২. ইনভেন্টরি থেকে রক্ত কমানো (Decrement)
            $inv->decrement('units', $req->units);

            return back()->with('success', 'Request approved and stock updated.');
        });
    }
}