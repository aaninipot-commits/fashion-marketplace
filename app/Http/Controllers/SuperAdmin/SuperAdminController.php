<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Message;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    // ── DASHBOARD ───────────────────────────────────────
    public function dashboard()
    {
        $stats = [
            'total_sellers'  => User::where('role', 'admin')->count(),
            'total_buyers'   => User::where('role', 'user')->count(),
            'total_products' => Product::count(),
            'total_messages' => Message::count(),
            'total_support'  => ContactMessage::count(),
            'unread_support' => ContactMessage::where('is_read', false)->count(),
            'banned_users'   => User::where('is_banned', true)->count(),
            'pending_shops'  => User::where('role', 'admin')->where('is_approved', 'pending')->count(),
        ];

        $recentSellers  = User::where('role', 'admin')->latest()->take(5)->get();
        $recentSupport  = ContactMessage::with('user')->latest()->take(5)->get();
        $recentProducts = Product::with(['seller', 'category'])->latest()->take(5)->get();

        return view('superadmin.dashboard', compact('stats', 'recentSellers', 'recentSupport', 'recentProducts'));
    }

    // ── SELLERS ─────────────────────────────────────────
    public function sellers()
    {
        $sellers = User::where('role', 'admin')
            ->withCount('products')
            ->latest()
            ->get();
        return view('superadmin.sellers', compact('sellers'));
    }

    public function approveSeller(User $user)
    {
        $user->update(['is_approved' => 'approved']);
        return response()->json(['success' => 'Seller approved successfully.']);
    }

    public function banSeller(User $user)
    {
        $isBanned = $user->is_banned ? false : true;
        $user->update(['is_banned' => $isBanned]);
        $msg = $isBanned ? 'Seller banned successfully.' : 'Seller unbanned successfully.';
        return response()->json(['success' => $msg, 'is_banned' => $isBanned]);
    }

    public function deleteSeller(User $user)
    {
        $user->delete();
        return response()->json(['success' => 'Seller deleted successfully.']);
    }

    // ── BUYERS ──────────────────────────────────────────
    public function buyers()
    {
        $buyers = User::where('role', 'user')->latest()->get();
        return view('superadmin.buyers', compact('buyers'));
    }

    public function banBuyer(User $user)
    {
        $isBanned = $user->is_banned ? false : true;
        $user->update(['is_banned' => $isBanned]);
        $msg = $isBanned ? 'Buyer banned successfully.' : 'Buyer unbanned successfully.';
        return response()->json(['success' => $msg, 'is_banned' => $isBanned]);
    }

    public function deleteBuyer(User $user)
    {
        $user->delete();
        return response()->json(['success' => 'Buyer deleted successfully.']);
    }

    // ── PRODUCTS ────────────────────────────────────────
    public function products()
    {
        $products = Product::with(['seller', 'category'])->latest()->get();
        return view('superadmin.products', compact('products'));
    }

    public function deleteProduct(Product $product)
    {
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }
        $product->delete();
        return response()->json(['success' => 'Product deleted successfully.']);
    }

    // ── CATEGORIES ──────────────────────────────────────
    public function categories()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('superadmin.categories', compact('categories'));
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        return response()->json(['success' => 'Category deleted successfully.']);
    }

    // ── MESSAGES ────────────────────────────────────────
    public function messages()
    {
        $messages = Message::with(['user', 'product'])->latest()->get();
        return view('superadmin.messages', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:191',
            'message' => 'required|string',
        ]);

        $user = User::find($request->user_id);

        // Store as contact message from superadmin
        ContactMessage::create([
            'user_id' => $request->user_id,
            'name'    => 'Super Admin',
            'email'   => 'superadmin@fashion.com',
            'subject' => $request->subject,
            'type'    => 'Admin Message',
            'message' => $request->message,
            'reply'   => null,
            'is_read' => false,
        ]);

        return response()->json(['success' => 'Message sent to ' . $user->name . ' successfully!']);
    }

    // ── SUPPORT ─────────────────────────────────────────
    public function support()
    {
        $messages = ContactMessage::with('user')->latest()->get();
        return view('superadmin.support', compact('messages'));
    }

    public function replySupport(Request $request, ContactMessage $message)
    {
        $request->validate(['reply' => 'required|string']);

        $message->reply   = $request->reply;
        $message->is_read = true;
        $message->save();

        return response()->json(['success' => 'Reply sent successfully.']);
    }

    public function deleteSupport(ContactMessage $message)
    {
        $message->delete();
        return response()->json(['success' => 'Message deleted successfully.']);
    }
}
