<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Tuition;

class TutorDashboardController extends Controller
{
    /**
     * Display tutor dashboard
     */
    public function index()
    {
        $tutor = auth()->user()->tutor;
        
        // Statistics
        $stats = [
            'total_applications' => $tutor->applications()->count(),
            'pending_applications' => $tutor->applications()->where('status', 'Pending')->count(),
            'shortlisted_applications' => $tutor->applications()->where('status', 'Shortlisted')->count(),
            'active_tuitions' => $tutor->tuitions()
                                       ->where('status', 'Active')
                                       ->count(),
            'completed_tuitions' => $tutor->tuitions()
                                          ->where('status', 'Completed')
                                          ->count(),
            'total_earnings' => $tutor->tuitions()
                                      ->where('status', 'Completed')
                                      ->sum('monthly_salary'),
        ];
        
        // Recent applications
        $recentApplications = $tutor->applications()
                                    ->with(['tuitionPost.guardian.user', 'tuitionPost.area'])
                                    ->latest()
                                    ->take(5)
                                    ->get();
        
        // Active tuitions
        $activeTuitions = $tutor->tuitions()
                                ->with(['guardian.user', 'tuitionPost'])
                                ->where('status', 'Active')
                                ->latest()
                                ->take(5)
                                ->get();
        
        // Profile completion check
        $profileComplete = $tutor && 
                          $tutor->subjects && 
                          count($tutor->subjects) > 0 &&
                          $tutor->qualifications()->count() > 0 &&
                          $tutor->documents()->count() > 0;
        
        return view('tutor.dashboard', compact('stats', 'recentApplications', 'activeTuitions', 'profileComplete'));
    }
}
