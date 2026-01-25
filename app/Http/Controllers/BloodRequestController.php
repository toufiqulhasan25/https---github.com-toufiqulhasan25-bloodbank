<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BloodRequestController extends Controller
{
    public function create()
    {
        return view('hospital.request');
    }

    public function store(Request $r)
    {
        Log::info('BloodRequestController@store called', ['user_id' => optional($r->user())->id, 'session' => $r->session()->all()]);
        $data = $r->validate([
            'hospital_name' => 'required|string|max:255',
            'blood_group' => 'required|string|max:10',
            'units' => 'required|integer|min:1',
        ]);

        BloodRequest::create($data);
        return redirect('/hospital/request')->with('success', 'Request submitted');
    }

    public function manage()
    {
        $requests = BloodRequest::all();
        return view('manager.requests', compact('requests'));
    }

    public function approve($id)
    {
        $req = BloodRequest::findOrFail($id);

        if ($req->status !== 'pending') {
            return back()->with('error', 'Request is not pending');
        }

        return DB::transaction(function () use ($req) {
            $inv = Inventory::where('blood_group', $req->blood_group)->lockForUpdate()->first();
            if (!$inv) {
                return back()->with('error', 'No inventory for requested blood group');
            }

            if ($inv->units < $req->units) {
                return back()->with('error', 'Not enough units in inventory');
            }

            $req->update(['status' => 'approved']);
            $inv->decrement('units', $req->units);

            return back()->with('success', 'Request approved');
        });
    }
}

