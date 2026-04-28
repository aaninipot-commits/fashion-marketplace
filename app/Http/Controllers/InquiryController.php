<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class InquiryController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'message'    => 'required|string',
        ]);

        Message::create([
            'user_id'    => Auth::id(),
            'product_id' => $request->product_id,
            'message'    => $request->message,
            'sender'     => 'user',
            'is_read'    => false,
        ]);

        return response()->json(['success' => 'Message sent! The seller will reply soon.']);
    }
}