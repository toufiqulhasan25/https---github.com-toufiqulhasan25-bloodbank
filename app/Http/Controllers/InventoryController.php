<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{

    public function index()
    {
        $data = Inventory::all();
        return view('manager.inventory', compact('data'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'blood_group' => 'required|string|max:10',
            'units' => 'required|integer|min:1',
            'expiry_date' => 'required|date',
        ]);

        Inventory::create($data);

        return back()->with('success', 'Blood added successfully');
    }


    public function expiryAlerts()
    {
        $soon = Carbon::now()->addDays(7);

        $alerts = Inventory::whereDate('expiry_date', '<=', $soon)->get();

        return view('manager.expiry_alerts', compact('alerts'));
    }

}

