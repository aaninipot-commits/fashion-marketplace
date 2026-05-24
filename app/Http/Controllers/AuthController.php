<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Laravel\Socialite\Facades\Socialite;
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
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
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

    // ── GOOGLE ──────────────────────────────────────────
    public function redirectToGoogle()
    {
        $httpClient = new \GuzzleHttp\Client([
            'verify' => false,
        ]);

        $provider = Socialite::driver('google');

        $reflectionClass = new \ReflectionClass($provider);
        $reflectionProperty = $reflectionClass->getParentClass()->getProperty('httpClient');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($provider, $httpClient);

        return $provider->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $httpClient = new \GuzzleHttp\Client([
                'verify' => false,
            ]);

            $provider = Socialite::driver('google');

            $reflectionClass = new \ReflectionClass($provider);
            $reflectionProperty = $reflectionClass->getParentClass()->getProperty('httpClient');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($provider, $httpClient);

            $googleUser = $provider->user();

            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Existing user - just log them in
                Auth::login($user);
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->route('home');
            }

            // New user - store Google data in session and ask for role
            session([
                'google_name'    => $googleUser->getName(),
                'google_email'   => $googleUser->getEmail(),
                'google_id'      => $googleUser->getId(),
                'google_avatar'  => $googleUser->getAvatar(),
            ]);

            return redirect()->route('google.role');
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            return redirect()->route('auth.google');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Google login failed: ' . $e->getMessage()]);
        }
    }

    // ── GOOGLE ROLE SELECTION ───────────────────────────
    public function showGoogleRole()
    {
        // If no Google session data, redirect to login
        if (!session('google_email')) {
            return redirect()->route('login');
        }
        return view('auth.google_role');
    }

    public function saveGoogleRole(Request $request)
    {
        $request->validate([
            'role'             => 'required|in:user,admin',
            'shop_name'        => 'required_if:role,admin|nullable|string|max:191',
            'shop_description' => 'nullable|string|max:191',
        ]);

        // Check if session data exists
        if (!session('google_email')) {
            return redirect()->route('login');
        }

        $user = User::create([
            'name'              => session('google_name'),
            'email'             => session('google_email'),
            'password'          => Hash::make(Str::random(24)),
            'role'              => $request->role,
            'shop_name'         => $request->shop_name,
            'shop_description'  => $request->shop_description,
            'google_id'         => session('google_id'),
            'profile_photo_url' => session('google_avatar'),
        ]);

        // Clear Google session data
        session()->forget(['google_name', 'google_email', 'google_id', 'google_avatar']);

        Auth::login($user);

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    }

    // ── FORGOT PASSWORD ─────────────────────────────────
    public function showForgotPassword()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Password reset link sent to your email!');
        }

        return back()->withErrors(['email' => 'No account found with that email address.']);
    }

    public function showResetPassword(Request $request, $token)
    {
        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('success', 'Password reset successfully! Please login.');
        }

        return back()->withErrors(['email' => 'Reset link is invalid or expired.']);
    }
}
