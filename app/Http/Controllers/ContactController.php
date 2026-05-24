<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:191',
            'type'    => 'required|string|max:191',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create([
            'user_id' => Auth::id(),
            'name'    => Auth::user()->name,
            'email'   => Auth::user()->email,
            'subject' => $request->subject,
            'type'    => $request->type,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return back()->with('success', 'Your message has been sent! We will get back to you soon.');
    }
}