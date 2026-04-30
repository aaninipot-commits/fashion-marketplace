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
            'message'    => 'required|string|max:1000',
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

    public function myMessages()
    {
        // Get all products the user has inquired about
        $conversations = Message::with(['product.seller', 'product.category'])
            ->where('user_id', Auth::id())
            ->where('sender', 'user')
            ->select('product_id')
            ->distinct()
            ->get()
            ->map(function($msg) {
                $lastMessage = Message::where('user_id', Auth::id())
                    ->where('product_id', $msg->product_id)
                    ->latest()
                    ->first();
                $unreadCount = Message::where('user_id', Auth::id())
                    ->where('product_id', $msg->product_id)
                    ->where('sender', 'admin')
                    ->where('is_read', false)
                    ->count();
                return [
                    'product'      => $msg->product,
                    'lastMessage'  => $lastMessage,
                    'unreadCount'  => $unreadCount,
                ];
            });

        return view('inquiry.my_messages', compact('conversations'));
    }

    public function getConversation($productId)
    {
        // Mark admin messages as read
        Message::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->where('sender', 'admin')
            ->update(['is_read' => true]);

        $messages = Message::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->with(['product'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }
}