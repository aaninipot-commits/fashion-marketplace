<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $sellerProductIds = Product::where('seller_id', Auth::id())->pluck('id');

        // Get unique conversations (one per user per product)
        $conversations = Message::with(['user', 'product'])
            ->whereIn('product_id', $sellerProductIds)
            ->where('sender', 'user')
            ->select('user_id', 'product_id')
            ->distinct()
            ->get()
            ->map(function($msg) {
                $lastMessage = Message::where('user_id', $msg->user_id)
                    ->where('product_id', $msg->product_id)
                    ->latest()
                    ->first();
                $unreadCount = Message::where('user_id', $msg->user_id)
                    ->where('product_id', $msg->product_id)
                    ->where('sender', 'user')
                    ->where('is_read', false)
                    ->count();
                return [
                    'user'        => $msg->user,
                    'product'     => $msg->product,
                    'lastMessage' => $lastMessage,
                    'unreadCount' => $unreadCount,
                ];
            });

        return view('admin.messages.index', compact('conversations'));
    }

    public function show(Message $message)
    {
        // Mark user messages as read
        Message::where('user_id', $message->user_id)
            ->where('product_id', $message->product_id)
            ->where('sender', 'user')
            ->update(['is_read' => true]);

        $conversation = Message::where('user_id', $message->user_id)
            ->where('product_id', $message->product_id)
            ->with(['user', 'product'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($conversation);
    }

    public function reply(Request $request, Message $message)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        Message::create([
            'user_id'    => $message->user_id,
            'product_id' => $message->product_id,
            'message'    => $request->message,
            'sender'     => 'admin',
            'is_read'    => false,
        ]);

        return response()->json(['success' => 'Reply sent successfully.']);
    }

    public function destroy(Message $message)
    {
        // Delete entire conversation
        Message::where('user_id', $message->user_id)
            ->where('product_id', $message->product_id)
            ->delete();

        return response()->json(['success' => 'Conversation deleted successfully.']);
    }
}