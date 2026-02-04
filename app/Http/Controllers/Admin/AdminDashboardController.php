<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TuitionPost;
use App\Models\Tuition;
use App\Models\Application;
use App\Models\CommissionPayout;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard with pending actions
     */
    public function index()
    {
        // Pending actions count
        $pending = [
            'profile_approvals' => User::whereNotNull('profile_completed_at')
                                       ->whereNull('approved_at')
                                       ->whereNull('rejected_at')
                                       ->count(),
            'post_approvals' => TuitionPost::where('status', 'Pending Approval')->count(),
            'tuition_verifications' => Tuition::where('status', 'Pending')
                                              ->whereNotNull('tutor_confirmed_at')
                                              ->whereNotNull('guardian_confirmed_at')
                                              ->count(),
            'commission_approvals' => Tuition::where('has_commission', true)
                                            ->where('commission_status', 'Pending')
                                            ->whereNotNull('admin_verified_at')
                                            ->count(),
            'payout_requests' => CommissionPayout::where('status', 'Requested')->count(),
        ];
        
        // Platform statistics
        $stats = [
            'total_users' => User::count(),
            'total_tutors' => User::where('type', 3)->whereNotNull('approved_at')->count(),
            'total_guardians' => User::where('type', 4)->whereNotNull('approved_at')->count(),
            'total_partners' => User::where('type', 5)->whereNotNull('approved_at')->count(),
            'active_posts' => TuitionPost::where('status', 'Active')->count(),
            'active_tuitions' => Tuition::where('status', 'Active')->count(),
            'total_applications' => Application::count(),
        ];
        
        // Recent activities
        $recentProfiles = User::whereNotNull('profile_completed_at')
                             ->whereNull('approved_at')
                             ->whereNull('rejected_at')
                             ->latest('profile_completed_at')
                             ->take(5)
                             ->get();
        
        $recentTuitions = Tuition::with(['tutor.user', 'guardian.user'])
                                ->latest()
                                ->take(5)
                                ->get();
        
        return view('admin.dashboard', compact('pending', 'stats', 'recentProfiles', 'recentTuitions'));
    }
}
