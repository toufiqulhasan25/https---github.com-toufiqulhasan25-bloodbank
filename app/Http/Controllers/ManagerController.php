<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\BloodRequest;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    // ১. ম্যানেজার ড্যাশবোর্ড ওভারভিউ
    public function index()
    {
        // মোট ব্লাড স্টক (units কলাম ব্যবহার করে)
        $total_units = Inventory::sum('units');

        // পেন্ডিং অ্যাপয়েন্টমেন্ট
        $pending_appts = Appointment::where('status', 'pending')->count();

        // হসপিটাল থেকে আসা পেন্ডিং রিকোয়েস্ট
        $pending_requests = BloodRequest::where('status', 'pending')->count();

        // ব্লাড গ্রুপ অনুযায়ী ইনভেন্টরি অ্যানালাইসিস
        $inventory = Inventory::select('blood_group', DB::raw('SUM(units) as units'))
            ->groupBy('blood_group')
            ->get();

        return view('manager.dashboard', compact(
            'total_units',
            'pending_appts',
            'pending_requests',
            'inventory'
        ));
    }

    // ২. ইনভেন্টরি বা রক্তের স্টক দেখা
    public function inventory()
    {
        $stockSummary = Inventory::select('blood_group', DB::raw('SUM(units) as total_units'))
            ->groupBy('blood_group')
            ->get();

        $data = Inventory::latest()->get();

        return view('manager.inventory', compact('data', 'stockSummary'));
    }

    // ৩. অ্যাপয়েন্টমেন্ট অ্যাপ্রুভ করা (স্টক বাড়বে)
    public function approveAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->status !== 'pending') {
            return back()->with('error', 'This appointment has already been processed.');
        }

        // স্ট্যাটাস আপডেট
        $appointment->update(['status' => 'approved']);

        // ইনভেন্টরিতে রক্ত যোগ করা (এখানে hospital_id সহ চেক করা ভালো)
        $inventory = Inventory::where('blood_group', $appointment->blood_group)
                              ->where('hospital_id', $appointment->hospital_id)
                              ->first();

        if ($inventory) {
            // আপনার ডাটাবেসে কলাম নাম 'units' হলে 'units' আপডেট করুন
            $inventory->increment('units'); 
        } else {
            Inventory::create([
                'hospital_id' => $appointment->hospital_id,
                'blood_group' => $appointment->blood_group,
                'units' => 1,
                'expiry_date' => now()->addDays(42),
            ]);
        }

        return back()->with('success', 'Appointment approved and inventory updated!');
    }

    // ৪. হসপিটাল ব্লাড রিকোয়েস্ট অ্যাপ্রুভ করা (স্টক কমবে)
    public function approveRequest($id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        $requestedAmount = (int) ($bloodRequest->bags_needed ?? $bloodRequest->units ?? 0);

        // স্টক চেক
        $totalAvailable = Inventory::where('blood_group', $bloodRequest->blood_group)->sum('units');

        if ($totalAvailable < $requestedAmount) {
            return back()->with('error', 'Insufficient stock for ' . $bloodRequest->blood_group);
        }

        // FIFO (First In First Out) পদ্ধতিতে স্টক কমানো
        $remainingToDeduct = $requestedAmount;
        $stocks = Inventory::where('blood_group', $bloodRequest->blood_group)
                    ->orderBy('created_at', 'asc')
                    ->get();

        foreach ($stocks as $stock) {
            if ($remainingToDeduct <= 0) break;

            if ($stock->units <= $remainingToDeduct) {
                $remainingToDeduct -= $stock->units;
                $stock->delete();
            } else {
                $stock->decrement('units', $remainingToDeduct);
                $remainingToDeduct = 0;
            }
        }

        $bloodRequest->status = 'approved';
        $bloodRequest->save();

        return back()->with('success', 'Hospital request approved! Stock updated.');
    }

    // ৫. রিকোয়েস্ট রিজেক্ট করা
    public function rejectRequest($id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        $bloodRequest->status = 'rejected';
        $bloodRequest->save();

        return back()->with('info', 'Request has been rejected.');
    }

    // ৬. অ্যানালিটিক্স রিপোর্ট (যা আপনার চার্ট আপডেট করবে)
    public function reports()
    {
        $total_donations = Appointment::where('status', 'approved')->count();

        // চার্টের জন্য ডেটা (Donation Frequency)
        $group_reports = Appointment::where('status', 'approved')
            ->select('blood_group', DB::raw('count(*) as total'))
            ->groupBy('blood_group')
            ->get();

        // বর্তমান ইনভেন্টরি চার্টের জন্য
        $inventory_report = Inventory::select('blood_group', DB::raw('SUM(units) as total_units'))
            ->groupBy('blood_group')
            ->get();

        // হসপিটাল ডিস্ট্রিবিউশন অ্যানালাইসিস
        $request_stats = BloodRequest::where('blood_requests.status', 'approved')
            ->join('users', 'blood_requests.hospital_id', '=', 'users.id')
            ->select('users.name as hospital_name', DB::raw('SUM(blood_requests.bags_needed) as total'))
            ->groupBy('users.id', 'users.name')
            ->get();

        return view('manager.reports', compact(
            'total_donations',
            'group_reports',
            'inventory_report',
            'request_stats'
        ));
    }

    public function profileShow()
    {
        $user = auth()->user();
        return view('manager.profile', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($request->only(['name', 'phone']));
        return back()->with('success', 'Profile updated successfully!');
    }

    public function destroyInventory($id)
    {
        $item = Inventory::findOrFail($id);
        $item->delete();
        return back()->with('success', 'Blood record removed successfully.');
    }
}