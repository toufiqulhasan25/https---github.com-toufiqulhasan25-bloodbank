<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // যেখানে ডোনার এবং হসপিটালের তথ্য আছে

class DonorSearchController extends Controller
{
    public function index(Request $request) {
    $bloodGroup = $request->input('blood_group');
    $location = $request->input('location');
    $type = $request->input('type');

    $query = User::query(); // User model-e role ba type thaka lagbe

    if ($bloodGroup) {
        $query->where('blood_group', $bloodGroup);
    }
    if ($location) {
        $query->where('address', 'like', "%$location%");
    }
    if ($type && $type !== 'all') {
        $query->where('role', $type);
    }

    $results = $query->get();

    return view('find-blood', compact('results'));
}
}