<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Tuition;
use Illuminate\Http\Request;

class GuardianApplicationController extends Controller
{
    /**
     * Display applications for guardian's posts
     */
    public function index(Request $request)
    {
        $guardian = auth()->user()->guardian;
        
        $query = Application::whereHas('tuitionPost', function($q) use ($guardian) {
                    $q->where('guardian_id', $guardian->id);
                })
                ->with(['tutor.user', 'tuitionPost']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by post
        if ($request->filled('post_id')) {
            $query->where('tuition_post_id', $request->post_id);
        }
        
        $applications = $query->latest()->paginate(15);
        
        // Get posts for filter
        $posts = $guardian->tuitionPosts()->get();
        
        return view('guardian.applications.index', compact('applications', 'posts'));
    }
    
    /**
     * Show application details
     */
    public function show($id)
    {
        $guardian = auth()->user()->guardian;
        
        $application = Application::with(['tutor.user', 'tutor.qualifications', 'tuitionPost'])
                                  ->whereHas('tuitionPost', function($q) use ($guardian) {
                                      $q->where('guardian_id', $guardian->id);
                                  })
                                  ->findOrFail($id);
        
        // Mark as viewed if pending
        if ($application->status === 'Pending') {
            $application->markAsViewed();
        }
        
        return view('guardian.applications.show', compact('application'));
    }
    
    /**
     * Shortlist an application
     */
    public function shortlist($id)
    {
        $guardian = auth()->user()->guardian;
        
        $application = Application::whereHas('tuitionPost', function($q) use ($guardian) {
                          $q->where('guardian_id', $guardian->id);
                      })
                      ->findOrFail($id);
        
        $application->markAsShortlisted();
        
        return back()->with('success', 'Application shortlisted successfully!');
    }
    
    /**
     * Accept an application and create tuition
     */
    public function accept(Request $request, $id)
    {
        $guardian = auth()->user()->guardian;
        
        $application = Application::whereHas('tuitionPost', function($q) use ($guardian) {
                          $q->where('guardian_id', $guardian->id);
                      })
                      ->findOrFail($id);
        
        $validated = $request->validate([
            'student_name' => 'required|string|max:200',
            'student_address' => 'required|string|max:500',
            'monthly_salary' => 'required|numeric|min:1000|max:100000',
            'start_date' => 'required|date|after_or_equal:today',
        ]);
        
        // Accept application (this will create tuition automatically)
        $application->accept($validated);
        
        return redirect()->route('guardian.tuitions.index')
                         ->with('success', 'Application accepted and tuition created!');
    }
    
    /**
     * Reject an application
     */
    public function reject(Request $request, $id)
    {
        $guardian = auth()->user()->guardian;
        
        $application = Application::whereHas('tuitionPost', function($q) use ($guardian) {
                          $q->where('guardian_id', $guardian->id);
                      })
                      ->findOrFail($id);
        
        $application->reject();
        
        return back()->with('success', 'Application rejected.');
    }
}
