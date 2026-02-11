<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\BloodStock;
use Illuminate\Http\Request;
use App\Models\Appointment; // যদি অ্যাপয়েন্টমেন্ট দেখাতে চান
use Illuminate\Support\Facades\Auth;

class HospitalController extends Controller
{

    // মেথডগুলো ক্লাসের ভেতরে যোগ করুন
    public function index()
    {
        $user = Auth::user();
        $stocks = BloodStock::where('user_id', $user->id)->get();
        $requests = BloodRequest::where('hospital_id', Auth::id())->latest()->get();
        return view('hospital.dashboard', compact('user', 'stocks', 'requests'));
    }

    public function updateStock(Request $request)
    {
        $request->validate([
            'blood_group' => 'required',
            'bags' => 'required|integer|min:0',
        ]);

        // যদি এই ব্লাড গ্রুপের ডাটা আগে থেকেই থাকে তবে আপডেট হবে, না থাকলে নতুন তৈরি হবে
        BloodStock::updateOrCreate(
            ['user_id' => Auth::id(), 'blood_group' => $request->blood_group],
            ['bags' => $request->bags]
        );

        return back()->with('success', 'Blood stock updated successfully!');
    }

  public function dashboard()
{
    $hospitalId = auth()->id();

    // নোটিফিকেশন লজিক (এটি ঠিক আছে)
    $unreadNotifications = BloodRequest::where('hospital_id', $hospitalId)
        ->whereIn('status', ['approved', 'rejected'])
        ->where('is_read', 0)
        ->get();

    if ($unreadNotifications->count() > 0) {
        BloodRequest::where('hospital_id', $hospitalId)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);
    }

    $requests = BloodRequest::where('hospital_id', $hospitalId)->latest()->get();

    // এই লাইনটি পরিবর্তন করুন: hospital_id এর বদলে user_id দিন
    $stocks = BloodStock::where('user_id', $hospitalId)->get(); 

    return view('hospital.dashboard', compact('requests', 'stocks', 'unreadNotifications'));
}
    public function approveRequest($id)
    {
        $request = BloodRequest::find($id);
        $request->status = 'approved';
        $request->save();

        // হসপিটালের জন্য সেশন মেসেজ সেট করা
        return back()->with('status_update', "Your request for {$request->blood_group} has been Approved!");
    }
}