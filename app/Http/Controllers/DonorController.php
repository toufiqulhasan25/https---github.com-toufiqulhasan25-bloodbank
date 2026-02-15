<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Notification; // নোটিফিকেশন মডেলটি ইমপোর্ট করুন
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; // উপরে এটি যোগ করুন

class DonorController extends Controller
{
    // ডোনার ড্যাশবোর্ড সামারি
    public function index()
    {
        $user = Auth::user();

        // নতুন নোটিফিকেশন চেক করা
        // আপনার কন্ট্রোলারের index মেথডের এই লাইনটি পরিবর্তন করুন:
        $notifications = Notification::where('user_id', $user->id)
            ->where('is_read', false) // শুধুমাত্র যেগুলো পড়া হয়নি
            ->latest()
            ->get();

        // মোট কতবার রক্ত দিয়েছে (Approved Appointments)
        $total_donations = Appointment::where('user_id', $user->id)
            ->where('status', 'approved')
            ->count();

        // সর্বশেষ রক্তদানের তথ্য
        $last_donation_date = $user->last_donation_date;
        $last_donation = Appointment::where('user_id', $user->id)
            ->where('status', 'approved')
            ->latest('date')
            ->first();

        // এলিজিবিলিটি ক্যালকুলেশন
        $isEligible = true;
        $daysUntilNext = 0;
        $nextEligibleDate = null;

        $effectiveDate = $last_donation_date ? Carbon::parse($last_donation_date) : ($last_donation ? Carbon::parse($last_donation->date) : null);

        if ($effectiveDate) {
            $diffInDays = $effectiveDate->diffInDays(now(), false);
            if ($diffInDays < 90) {
                $isEligible = false;
                $daysUntilNext = (int) ceil(now()->diffInSeconds($effectiveDate->copy()->addDays(90)) / 86400);
                $nextEligibleDate = $effectiveDate->copy()->addDays(90)->format('d M, Y');
            }
        }

        return view('donor.dashboard', compact(
            'total_donations',
            'last_donation',
            'isEligible',
            'daysUntilNext',
            'nextEligibleDate',
            'notifications' // নোটিফিকেশন ভিউতে পাঠানো হলো
        ));
    }

    // নতুন মেথড: কল করার সময় ডোনরকে নোটিফাই করা
    public function sendCallNotification($id, $group)
    {
        $donor = User::findOrFail($id);
        $requester = Auth::user();

        // নোটিফিকেশন তৈরি
        Notification::create([
            'user_id' => $donor->id,
            'sender_name' => $requester->name,
            'message' => "is looking for {$group} blood and may call you soon.",
            'is_read' => false,
        ]);

        // ডোনরের ফোন নাম্বারে রিডাইরেক্ট করা
        return redirect("tel:{$donor->phone}");
    }

    // নোটিফিকেশন 'Read' করার মেথড
    public function markNotificationRead($id)
    {
        // শুধুমাত্র নিজের নোটিফিকেশনই আপডেট করতে পারবে
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        return back()->with('success', 'Notification cleared!');
    }


    public function history()
    {
        $history = Appointment::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('donor.history', compact('history'));
    }

    public function generateCard()
    {
        $user = Auth::user();

        // ডোনরের মোট কতবার রক্ত দিয়েছে সেটি কার্ডে দেখানোর জন্য
        $total_donations = Appointment::where('user_id', $user->id)
            ->where('status', 'approved')
            ->count();

        return view('donor.card', compact('user', 'total_donations'));
    }




    public function downloadCertificate($id)
    {
        $donation = Appointment::with('hospital')->where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'approved')
            ->firstOrFail();

        $data = [
            'donation' => $donation,
            'user' => Auth::user(),
            'date' => date('d/m/Y'),
        ];

        $pdf = Pdf::loadView('donor.certificate_pdf', $data);

        // পেজ সেটআপ এবং মার্জিন জিরো করা
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions([
            'defaultPaperSize' => 'a4',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'margin_top' => 0,
            'margin_right' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
        ]);

        return $pdf->download('Certificate_NIYD_' . $donation->id . '.pdf');
    }

    public function showAppointment($id)
    {
        $appointment = Appointment::with('hospital')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('donor.appointment_details', compact('appointment'));
    }

    public function profileShow()
    {
        $user = auth()->user();
        return view('donor.profile', compact('user'));
    }

    // এটি আপনার কন্ট্রোলারের সবশেষে থাকা profileUpdate এর বদলে বসিয়ে দিন
    public function profileUpdate(Request $request)
    {
        $user = User::find(Auth::id());

        // ভ্যালিডেশন: এখানে field গুলো 'nullable' রাখা হয়েছে যাতে মডাল থেকে আপডেট করলে সমস্যা না হয়
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'last_donation_date' => 'nullable|date|before_or_equal:today',
            'address' => 'nullable|string|max:500',
        ]);

        // শুধুমাত্র যে ডাটাগুলো রিকোয়েস্টে পাঠানো হয়েছে সেগুলো ফিল্টার করে আপডেট করা
        $data = array_filter($request->only(['name', 'phone', 'last_donation_date', 'address']));

        // যদি last_donation_date রিকোয়েস্টে থাকে কিন্তু খালি থাকে, তবে সেটিও আপডেট হওয়া উচিত
        if ($request->has('last_donation_date')) {
            $data['last_donation_date'] = $request->last_donation_date;
        }

        $user->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }
}