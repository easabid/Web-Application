<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\TuitionPost;
use App\Models\Application;
use App\Models\CommissionPayout;

class PartnerDashboardController extends Controller
{
    /**
     * Display partner dashboard with earnings
     */
    public function index()
    {
        $partner = auth()->user()->partner;
        
        // Statistics
        $stats = [
            'total_posts' => $partner->tuitionPosts()->count(),
            'active_posts' => $partner->tuitionPosts()->where('status', 'Active')->count(),
            'total_applications' => Application::whereHas('tuitionPost', function($q) use ($partner) {
                $q->where('partner_id', $partner->id);
            })->count(),
            'confirmed_tuitions' => $partner->tuitions()
                                          ->whereNotNull('tutor_confirmed_at')
                                          ->whereNotNull('guardian_confirmed_at')
                                          ->count(),
        ];
        
        // Earnings statistics
        $earnings = [
            'pending_payout' => $partner->pending_payout,
            'total_earnings' => $partner->total_earnings,
            'total_paid' => $partner->total_paid,
            'lifetime_earnings' => $partner->total_earnings + $partner->total_paid,
        ];
        
        // Recent posts
        $recentPosts = $partner->tuitionPosts()
                              ->with(['area', 'classLevel', 'applications'])
                              ->latest()
                              ->take(5)
                              ->get();
        
        // Recent commission-earning tuitions
        $recentCommissions = $partner->tuitions()
                                    ->with(['tutor.user', 'tuitionPost'])
                                    ->where('has_commission', true)
                                    ->latest()
                                    ->take(5)
                                    ->get();
        
        return view('partner.dashboard', compact('stats', 'earnings', 'recentPosts', 'recentCommissions'));
    }
}
