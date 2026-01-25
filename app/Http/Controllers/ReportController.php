<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\BloodRequest;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Use DB driver-specific month extraction: SQLite uses strftime
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            $monthlyRequests = BloodRequest::selectRaw("strftime('%m', created_at) as m, COUNT(*) as total")
                ->groupBy('m')->pluck('total', 'm');

            $monthlyAppointments = Appointment::selectRaw("strftime('%m', created_at) as m, COUNT(*) as total")
                ->groupBy('m')->pluck('total', 'm');
        } else {
            $monthlyRequests = BloodRequest::selectRaw('MONTH(created_at) m, COUNT(*) total')
                ->groupBy('m')->pluck('total', 'm');

            $monthlyAppointments = Appointment::selectRaw('MONTH(created_at) m, COUNT(*) total')
                ->groupBy('m')->pluck('total', 'm');
        }

        $stock = Inventory::pluck('units', 'blood_group');

        return view('manager.reports', compact('monthlyRequests', 'monthlyAppointments', 'stock'));
    }
}