<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'name'             => 'required|string|max:191',
            'email'            => 'required|email|unique:users,email,' . $user->id,
            'phone'            => 'nullable|string|max:191',
            'address'          => 'nullable|string|max:191',
            'shop_name'        => 'nullable|string|max:191',
            'shop_description' => 'nullable|string|max:191',
            'profile_photo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name'             => $request->name,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'address'          => $request->address,
            'shop_name'        => $request->shop_name,
            'shop_description' => $request->shop_description,
        ];

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo
            if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
                unlink(public_path($user->profile_photo));
            }
            $file     = $request->file('profile_photo');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('profile_photos'), $filename);
            $data['profile_photo'] = 'profile_photos/' . $filename;
        }

        $user->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function upgrade(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'shop_name'        => 'required|string|max:191',
            'shop_description' => 'nullable|string|max:191',
        ]);

        $user->update([
            'role'             => 'admin',
            'is_approved'      => 'pending',
            'shop_name'        => $request->shop_name,
            'shop_description' => $request->shop_description,
        ]);

        return back()->with('success', 'Your seller application has been submitted! Please wait for Super Admin approval before you can start selling.');
    }
}
