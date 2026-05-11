<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Get only users who have sent inquiries to this seller's products
        $sellerProductIds = Product::where('seller_id', Auth::id())->pluck('id');

        $users = User::where('role', 'user')
            ->whereHas('messages', function($query) use ($sellerProductIds) {
                $query->whereIn('product_id', $sellerProductIds);
            })
            ->withCount(['messages as inquiry_count' => function($query) use ($sellerProductIds) {
                $query->whereIn('product_id', $sellerProductIds)
                      ->where('sender', 'user');
            }])
            ->latest()
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:191',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone'    => 'nullable|string|max:191',
            'address'  => 'nullable|string|max:191',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'address'  => $request->address,
            'role'     => 'user',
        ]);

        return response()->json(['success' => 'User created successfully.']);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'    => 'required|string|max:191',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'phone'   => 'nullable|string|max:191',
            'address' => 'nullable|string|max:191',
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'success' => 'User updated successfully.',
            'user'    => $user
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => 'User deleted successfully.']);
    }
}