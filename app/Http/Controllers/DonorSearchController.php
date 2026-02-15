<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class DonorSearchController extends Controller
{
    public function index(Request $request)
    {
        $bloodGroup = $request->input('blood_group');
        $location = $request->input('location');
        $type = $request->input('type');

        // ১. কুয়েরি শুরু করা
        $query = User::query();

        // ২. শুধুমাত্র ডোনার এবং হসপিটাল ফিল্টার করা
        $query->whereIn('role', ['donor', 'hospital']);

        // ৩. ডাইনামিক ব্লাড গ্রুপ ফিল্টার (ডোনার এবং হসপিটালের জন্য আলাদা লজিক)
        if ($request->filled('blood_group')) {
            $query->where(function (Builder $q) use ($bloodGroup) {
                // ডোনারের ক্ষেত্রে সরাসরি কলাম চেক
                $q->where(function ($sub) use ($bloodGroup) {
                    $sub->where('role', 'donor')
                        ->where('blood_group', $bloodGroup);
                })
                // হসপিটালের ক্ষেত্রে blood_stocks টেবিল চেক
                ->orWhere(function ($sub) use ($bloodGroup) {
                    $sub->where('role', 'hospital')
                        ->whereHas('stocks', function ($stockQuery) use ($bloodGroup) {
                            $stockQuery->where('blood_group', $bloodGroup)
                                       ->where('bags', '>', 0);
                        });
                });
            });
        }

        // ৪. লোকেশন ফিল্টার
        if ($request->filled('location')) {
            $query->where('address', 'like', "%$location%");
        }

        // ৫. সোর্স টাইপ ফিল্টার (ডোনার নাকি হসপিটাল)
        if ($request->filled('type') && $type !== 'all') {
            $query->where('role', $type);
        }

        // ৬. রেজাল্ট নিয়ে আসা (Pagination সহ)
        $results = $query->with('stocks')->latest()->paginate(10)->withQueryString();

        return view('find-blood', compact('results'));
    }
}