<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileApproved
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Admins don't need approval
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Check if profile is approved
        if (!$user->isApproved()) {
            if ($user->isRejected()) {
                return redirect()->route('profile.rejected')
                    ->with('error', 'Your profile has been rejected. Please review and resubmit.');
            }

            if ($user->isPending()) {
                return redirect()->route('profile.pending')
                    ->with('info', 'Your profile is pending approval.');
            }

            // Profile not complete
            return redirect()->route('profile.create')
                ->with('info', 'Please complete your profile first.');
        }

        // Check if suspended
        if ($user->is_suspended) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Your account has been suspended. Reason: ' . $user->suspended_reason);
        }

        return $next($request);
    }
}
