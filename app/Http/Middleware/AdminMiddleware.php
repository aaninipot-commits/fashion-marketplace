<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->is_banned) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => '🚫 Your account has been banned. Please contact superadmin@fashion.com to appeal.']);
        }

        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home');
        }

        if (Auth::user()->is_approved === 'pending') {
            return redirect()->route('home')
                ->with('warning', '⏳ Your seller account is pending approval from the Super Admin. You will be notified once approved.');
        }

        return $next($request);
    }
}