<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Redirect admin to admin dashboard
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // Redirect user to home
            return redirect()->route('home');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:191',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|min:6|confirmed',
            'role'             => 'required|in:user,admin',
            'shop_name'        => 'required_if:role,admin|nullable|string|max:191',
            'shop_description' => 'nullable|string|max:191',
        ]);

        User::create([
            'name'             => $request->name,
            'email'            => $request->email,
            'password'         => Hash::make($request->password),
            'role'             => $request->role,
            'shop_name'        => $request->shop_name,
            'shop_description' => $request->shop_description,
        ]);

        return redirect()->route('login')->with('success', 'Account created! Please login.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
