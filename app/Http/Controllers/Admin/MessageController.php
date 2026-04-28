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
        // Only show messages for seller's own products
        $sellerProductIds = Product::where('seller_id', Auth::id())->pluck('id');

        $messages = Message::with(['user', 'product'])
            ->whereIn('product_id', $sellerProductIds)
            ->where('sender', 'user')
            ->latest()
            ->get();

        return view('admin.messages.index', compact('messages'));
    }

    public function show(Message $message)
    {
        // Verify this message belongs to seller's product
        $product = Product::where('id', $message->product_id)
                    ->where('seller_id', Auth::id())
                    ->first();

        if (!$product) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        $message->update(['is_read' => true]);

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
        $message->delete();
        return response()->json(['success' => 'Message deleted successfully.']);
    }
}