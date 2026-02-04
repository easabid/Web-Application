<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\TuitionPost;
use App\Models\Application;

class GuardianDashboardController extends Controller
{
    /**
     * Display guardian dashboard
     */
    public function index()
    {
        $guardian = auth()->user()->guardian;
        
        // Statistics
        $stats = [
            'total_posts' => $guardian->tuitionPosts()->count(),
            'active_posts' => $guardian->tuitionPosts()->where('status', 'Active')->count(),
            'total_applications' => Application::whereHas('tuitionPost', function($q) use ($guardian) {
                $q->where('guardian_id', $guardian->id);
            })->count(),
            'pending_applications' => Application::whereHas('tuitionPost', function($q) use ($guardian) {
                $q->where('guardian_id', $guardian->id);
            })->where('status', 'Pending')->count(),
            'active_tuitions' => $guardian->tuitions()
                                        ->where('status', 'Active')
                                        ->count(),
            'completed_tuitions' => $guardian->tuitions()
                                           ->where('status', 'Completed')
                                           ->count(),
        ];
        
        // Recent posts
        $recentPosts = $guardian->tuitionPosts()
                                ->with(['area', 'applications'])
                                ->latest()
                                ->take(5)
                                ->get();
        
        // Recent applications
        $recentApplications = Application::whereHas('tuitionPost', function($q) use ($guardian) {
                                    $q->where('guardian_id', $guardian->id);
                                })
                                ->with(['tutor.user', 'tuitionPost'])
                                ->latest()
                                ->take(5)
                                ->get();
        
        return view('guardian.dashboard', compact('stats', 'recentPosts', 'recentApplications'));
    }
}
