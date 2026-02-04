<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfProfileIncomplete
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

        // Admins don't need profile completion
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Check if profile is complete
        if (!$user->isProfileComplete()) {
            $route = match($user->type) {
                config('findtutors.user_types.TUTOR') => 'tutor.profile.create',
                config('findtutors.user_types.GUARDIAN') => 'guardian.profile.create',
                config('findtutors.user_types.PARTNER') => 'partner.profile.create',
                default => 'home',
            };

            return redirect()->route($route)
                ->with('info', 'Please complete your profile to continue.');
        }

        return $next($request);
    }
}
