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

    $user = auth()->user();
    $user->update([
        'last_donation_date' => $request->last_donation_date
    ]);

    return back()->with('success', 'Donation date updated successfully!');
}
}
