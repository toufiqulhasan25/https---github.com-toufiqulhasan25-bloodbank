<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\BloodStock;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use App\Models\PatientRequest;
use Illuminate\Support\Facades\DB;
use App\Notifications\BloodRequestStatusNotification;

class HospitalController extends Controller
{
    /**
     * Hospital Dashboard - Single Entry Point
     */
    public function index(Request $request)
    {
        $hospitalId = Auth::id();

        // ১. নোটিফিকেশন মার্ক এজ রিড (AJAX রিকোয়েস্টের জন্য)
        if ($request->ajax() && $request->isMethod('post')) {
            BloodRequest::where('hospital_id', $hospitalId)
                ->where('is_read', 0)
                ->update(['is_read' => 1]);
            return response()->json(['success' => true]);
        }

        // ২. শুধুমাত্র অপঠিত নোটিফিকেশনগুলো আনা (is_read = 0)
        // refresh করলে এগুলো database থেকে আর আসবে না যদি is_read = 1 হয়ে যায়
        $unreadNotifications = BloodRequest::where('hospital_id', $hospitalId)
            ->whereIn('status', ['approved', 'rejected'])
            ->where('is_read', 0)
            ->get();

        // ৩. ড্যাশবোর্ড টেবিলের জন্য লেটেস্ট ৫টি রিকোয়েস্ট
        $requests = BloodRequest::where('hospital_id', $hospitalId)
            ->latest()
            ->take(5)
            ->get();

        // ৪. অ্যানালিটিক্স কার্ড ডেটা
        $pendingCount = BloodRequest::where('hospital_id', $hospitalId)->where('status', 'pending')->count();
        $allRequestsCount = BloodRequest::where('hospital_id', $hospitalId)->count();

        // ৫. ব্লাড স্টক ডেটা
        $stocks = BloodStock::where('user_id', $hospitalId)->get();
        $user = Auth::user();

        return view('hospital.dashboard', compact(
            'user',
            'requests',
            'stocks',
            'unreadNotifications',
            'pendingCount',
            'allRequestsCount'
        ));
    }

    /**
     * Update Blood Stock Inventory
     */
    public function updateStock(Request $request)
    {
        $request->validate([
            'blood_group' => 'required',
            'bags' => 'required|integer|min:0',
        ]);

        BloodStock::updateOrCreate(
            ['user_id' => Auth::id(), 'blood_group' => $request->blood_group],
            ['bags' => $request->bags]
        );

        return back()->with('success', 'Blood stock updated successfully!');
    }

    /**
     * Mark all notifications as read manually (Optional Route)
     */
    public function markRead()
    {
        BloodRequest::where('hospital_id', Auth::id())
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }

    public function approveRequest($id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        $bloodRequest->status = 'approved';
        $bloodRequest->save();

        return back()->with('success', "Request for {$bloodRequest->blood_group} has been Approved!");
    }

    public function profileShow()
    {
        $user = Auth::user();
        return view('hospital.profile', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
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
        $bloodRequest = BloodRequest::where('hospital_id', Auth::id())->findOrFail($id);
        return view('hospital.request_details', compact('bloodRequest'));
    }



    public function approvePatientRequest($id)
    {
        $patientRequest = PatientRequest::findOrFail($id);

        if ($patientRequest->hospital_id != auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $stock = DB::table('blood_stocks')
            ->where('user_id', auth()->id())
            ->where('blood_group', $patientRequest->blood_group)
            ->first();

        if (!$stock || $stock->bags < $patientRequest->bags) {
            return back()->with('error', 'Not enough blood stock available for this request.');
        }

        // ট্রানজেকশনের ভেতরে সবকিছু রাখা নিরাপদ
        DB::transaction(function () use ($patientRequest, $stock) {
            // ১. স্টক কমানো
            DB::table('blood_stocks')
                ->where('id', $stock->id)
                ->decrement('bags', $patientRequest->bags);

            // ২. রিকোয়েস্ট স্ট্যাটাস আপডেট
            $patientRequest->update(['status' => 'approved']);

            // ৩. আপনার কাস্টম নোটিফিকেশন টেবিলে ইনসার্ট
            DB::table('notifications')->insert([
                'user_id' => $patientRequest->user_id,
                'sender_name' => auth()->user()->name,
                'message' => "Your blood request for " . $patientRequest->patient_name . " has been APPROVED.",
                'is_read' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        // লারাভেল ডিফল্ট নোটিফিকেশন (ইমেইল বা ব্রডকাস্টের জন্য থাকলে)
        try {
            $patientRequest->user->notify(new BloodRequestStatusNotification('approved', auth()->user()->name));
        } catch (\Exception $e) {
            // নোটিফিকেশন ফেইল করলেও যেন মেইন প্রসেস না আটকায়
        }

        return back()->with('success', 'রিকোয়েস্টটি সফলভাবে এপ্রুভ করা হয়েছে এবং স্টক আপডেট করা হয়েছে।');
    }

    public function rejectPatientRequest($id)
    {
        $patientRequest = PatientRequest::findOrFail($id);

        if ($patientRequest->hospital_id != auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        DB::transaction(function () use ($patientRequest) {
            $patientRequest->update(['status' => 'rejected']);

            DB::table('notifications')->insert([
                'user_id' => $patientRequest->user_id,
                'sender_name' => auth()->user()->name,
                'message' => "Your blood request for " . $patientRequest->patient_name . " has been REJECTED.",
                'is_read' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        try {
            $patientRequest->user->notify(new BloodRequestStatusNotification('rejected', auth()->user()->name));
        } catch (\Exception $e) { }

        return back()->with('success', 'Your request has been rejected successfully.');
    }


    public function viewPatientRequests()
    {
        // লগইন করা হাসপাতালের আইডি অনুযায়ী রিকোয়েস্টগুলো আনা হচ্ছে
        $requests = PatientRequest::where('hospital_id', auth()->id())
            ->with('user') // ইউজারের তথ্যসহ
            ->latest()
            ->paginate(10);

        return view('hospital.patient_requests', compact('requests'));
    }

    
}