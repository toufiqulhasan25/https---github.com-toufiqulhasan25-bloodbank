<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function updateDonationDate(Request $request)
    {
        $request->validate([
            'last_donation_date' => 'required|date|before_or_equal:today',
        ]);

        // সরাসরি আইডি দিয়ে আপডেট করা বেশি নিরাপদ
        \App\Models\User::where('id', auth()->id())->update([
            'last_donation_date' => $request->last_donation_date
        ]);

        return back()->with('success', 'Donation date updated successfully!');
    }
}
