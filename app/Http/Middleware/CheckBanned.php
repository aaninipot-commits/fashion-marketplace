<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBanned
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_banned) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => '🚫 Your account has been banned. Please contact support at superadmin@fashion.com to appeal your ban.']);
        }
        return $next($request);
    }
}