<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\TuitionPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TutorApplicationController extends Controller
{
    /**
     * Display tutor's applications
     */
    public function index(Request $request)
    {
        $query = auth()->user()->tutor->applications()
                     ->with(['tuitionPost.guardian.user', 'tuitionPost.area']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $applications = $query->latest()->paginate(15);
        
        return view('tutor.applications.index', compact('applications'));
    }
    
    /**
     * Show application details
     */
    public function show($id)
    {
        $application = Application::with(['tuitionPost.guardian.user', 'tuitionPost.area', 'tutor.user'])
                                  ->where('tutor_id', auth()->user()->tutor->id)
                                  ->findOrFail($id);
        
        return view('tutor.applications.show', compact('application'));
    }
    
    /**
     * Apply to a tuition post
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tuition_post_id' => 'required|exists:tuition_posts,id',
            'cover_letter' => 'required|string|min:50|max:1000',
            'expected_salary' => 'required|numeric|min:1000|max:100000',
        ]);
        
        $post = TuitionPost::findOrFail($validated['tuition_post_id']);
        
        // Check if post is still active
        if ($post->status !== 'Active' || $post->expires_at <= now()) {
            return back()->with('error', 'This tuition post is no longer accepting applications.');
        }
        
        // Check if already applied
        $existingApplication = Application::where('tutor_id', auth()->user()->tutor->id)
                                         ->where('tuition_post_id', $post->id)
                                         ->first();
        
        if ($existingApplication) {
            return back()->with('error', 'You have already applied to this post.');
        }
        
        // Create application
        $application = Application::create([
            'tutor_id' => auth()->user()->tutor->id,
            'tuition_post_id' => $post->id,
            'cover_letter' => $validated['cover_letter'],
            'expected_salary' => $validated['expected_salary'],
            'status' => 'Pending',
        ]);
        
        // Increment application count
        $post->increment('application_count');
        
        return redirect()->route('tutor.applications.show', $application->id)
                         ->with('success', 'Application submitted successfully!');
    }
    
    /**
     * Withdraw an application
     */
    public function destroy($id)
    {
        $application = Application::where('tutor_id', auth()->user()->tutor->id)
                                  ->findOrFail($id);
        
        if (!$application->canWithdraw()) {
            return back()->with('error', 'You cannot withdraw this application.');
        }
        
        $application->withdraw();
        
        return redirect()->route('tutor.applications.index')
                         ->with('success', 'Application withdrawn successfully.');
    }
}
