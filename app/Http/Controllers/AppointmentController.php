<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    public function create()
    {
        return view('donor.appointment');
    }

    public function store(Request $r)
    {
        Log::info('AppointmentController@store called', ['user_id' => optional($r->user())->id, 'session' => $r->session()->all()]);
        $data = $r->validate([
            'donor_name' => 'required|string|max:255',
            'blood_group' => 'required|string|max:10',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        Appointment::create($data);
        return redirect('/donor/appointment')->with('success', 'Appointment booked');
    }

    public function manage()
    {
        $apps = Appointment::all();
        return view('manager.appointments', compact('apps'));
    }

    public function approve($id)
    {
        $app = Appointment::findOrFail($id);
        if ($app->status !== 'pending') {
            return back()->with('error', 'Appointment is not pending');
        }

        $app->update(['status' => 'approved']);
        return back()->with('success', 'Appointment approved');
    }
}

