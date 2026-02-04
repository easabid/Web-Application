<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Display the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Update last login
            $user->update(['last_login_at' => now()]);

            // Check if email is verified
            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice')
                    ->with('warning', 'Please verify your email before continuing.');
            }

            // Check if suspended
            if ($user->is_suspended) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account has been suspended. Reason: ' . $user->suspended_reason,
                ]);
            }

            // Redirect based on user type
            return $this->redirectAfterLogin($user);
        }

        throw ValidationException::withMessages([
            'email' => __('These credentials do not match our records.'),
        ]);
    }

    /**
     * Redirect user after successful login based on their type.
     */
    protected function redirectAfterLogin($user)
    {
        $userTypes = config('findtutors.user_types');

        return match($user->type) {
            $userTypes['SUPER_ADMIN'], $userTypes['ADMIN'] => redirect()->intended('/admin/dashboard'),
            $userTypes['TUTOR'] => redirect()->intended('/tutor/dashboard'),
            $userTypes['GUARDIAN'] => redirect()->intended('/guardian/dashboard'),
            $userTypes['PARTNER'] => redirect()->intended('/partner/dashboard'),
            default => redirect('/'),
        };
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}
