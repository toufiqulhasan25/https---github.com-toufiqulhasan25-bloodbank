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

    public function dashboard(Request $request)
    {
        $hospitalId = auth()->id();

        // ১. নোটিফিকেশন লজিক (AJAX রিকোয়েস্ট হলে শুধু JSON রেসপন্স দিবে)
        if ($request->ajax()) {
            BloodRequest::where('hospital_id', $hospitalId)
                ->where('is_read', 0)
                ->update(['is_read' => 1]);
            return response()->json(['success' => true]);
        }

        // ২. অপঠিত নোটিফিকেশনগুলো গেট করা (ব্লেড ফাইলে দেখানোর জন্য)
        $unreadNotifications = BloodRequest::where('hospital_id', $hospitalId)
            ->whereIn('status', ['approved', 'rejected'])
            ->where('is_read', 0)
            ->get();

        // ৩. ড্যাশবোর্ডের টেবিলের জন্য মাত্র ৫টি লেটেস্ট রিকোয়েস্ট
        $requests = BloodRequest::where('hospital_id', $hospitalId)
            ->latest()
            ->take(5)
            ->get();

        // ৪. অ্যানালিটিক্স কার্ডের জন্য সব রিকোয়েস্টের কাউন্ট (ব্লেড ফাইলে ব্যবহারের জন্য)
        $allRequestsCount = BloodRequest::where('hospital_id', $hospitalId)->count();
        $pendingCount = BloodRequest::where('hospital_id', $hospitalId)->where('status', 'pending')->count();

        // ৫. স্টক ডাটা
        $stocks = BloodStock::where('user_id', $hospitalId)->get();

        return view('hospital.dashboard', compact(
            'requests',
            'stocks',
            'unreadNotifications',
            'pendingCount',
            'allRequestsCount'
        ));
    }
    public function approveRequest($id)
    {
        $request = BloodRequest::find($id);
        $request->status = 'approved';
        $request->save();

        // হসপিটালের জন্য সেশন মেসেজ সেট করা
        return back()->with('status_update', "Your request for {$request->blood_group} has been Approved!");
    }

    public function profileShow()
    {
        $user = auth()->user();
        return view('hospital.profile', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update($request->only(['name', 'phone', 'address']));
        return back()->with('success', 'Hospital profile updated successfully!');
    }

    public function show($id)
    {
        // শুধু লগইন করা হাসপাতালের রিকোয়েস্টটি খুঁজে বের করবে
        $bloodRequest = BloodRequest::where('hospital_id', auth()->id())->findOrFail($id);

        // আমরা যে ব্লেড ফাইলটি তৈরি করেছিলাম সেটি রিটার্ন করবে
        return view('hospital.request_details', compact('bloodRequest'));
    }
}