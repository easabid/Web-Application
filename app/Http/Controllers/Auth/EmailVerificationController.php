<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    /**
     * Display the email verification notice.
     */
    public function notice()
    {
        return view('auth.verify-email');
    }

    /**
     * Mark the authenticated user's email address as verified.
     */
    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectAfterVerification($request->user());
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect($this->redirectAfterVerification($request->user()))
            ->with('success', 'Email verified successfully!');
    }

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectAfterVerification($request->user());
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent!');
    }

    /**
     * Redirect user after email verification based on type.
     */
    protected function redirectAfterVerification($user)
    {
        $userTypes = config('findtutors.user_types');

        // Check if profile is complete
        if (!$user->isProfileComplete()) {
            return match($user->type) {
                $userTypes['TUTOR'] => route('tutor.profile.create'),
                $userTypes['GUARDIAN'] => route('guardian.profile.create'),
                $userTypes['PARTNER'] => route('partner.profile.create'),
                default => route('home'),
            };
        }

        // Redirect to dashboard
        return match($user->type) {
            $userTypes['SUPER_ADMIN'], $userTypes['ADMIN'] => route('admin.dashboard'),
            $userTypes['TUTOR'] => route('tutor.dashboard'),
            $userTypes['GUARDIAN'] => route('guardian.dashboard'),
            $userTypes['PARTNER'] => route('partner.dashboard'),
            default => route('home'),
        };
    }
}
