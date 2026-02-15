<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    // মেসেজ সেভ করার জন্য
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_info' => 'required|string',
            'message' => 'required|string',
        ]);

        Contact::create($request->all());

        return back()->with('success', 'Thank you! Your message has been sent successfully.');
    }

    // মেসেজগুলো দেখার জন্য (শুধুমাত্র অ্যাডমিন/ম্যানেজারদের জন্য)
    public function index()
    {
        $messages = Contact::latest()->get();
        return view('manager.admin_messages', compact('messages'));
    }
}