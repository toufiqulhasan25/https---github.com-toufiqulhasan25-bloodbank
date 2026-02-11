<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // যেখানে ডোনার এবং হসপিটালের তথ্য আছে

class DonorSearchController extends Controller
{
    public function index(Request $request)
    {
        $bloodGroup = $request->input('blood_group');
        $location = $request->input('location');
        $type = $request->input('type');

        // শুধুমাত্র ডোনার এবং হসপিটালদের সার্চ রেজাল্টে রাখা (ম্যানেজার বা এডমিন নয়)
        $query = User::whereIn('role', ['donor', 'hospital']);

        // ব্লাড গ্রুপ ফিল্টার
        if ($request->filled('blood_group')) {
            $query->where('blood_group', $bloodGroup);
        }

        // লোকেশন ফিল্টার
        if ($request->filled('location')) {
            $query->where('address', 'like', "%$location%");
        }

        // সোর্স টাইপ ফিল্টার (ডোনার নাকি হসপিটাল)
        if ($request->filled('type') && $type !== 'all') {
            $query->where('role', $type);
        }

        // get() এর বদলে paginate() ব্যবহার করুন যাতে total() এবং links() কাজ করে
        $results = $query->latest()->paginate(10)->withQueryString();

        return view('find-blood', compact('results'));
    }
}