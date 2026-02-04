<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Tuition;
use Illuminate\Http\Request;

class TutorTuitionController extends Controller
{
    /**
     * Display tutor's tuitions
     */
    public function index(Request $request)
    {
        $query = auth()->user()->tutor->tuitions()
                     ->with(['guardian.user', 'tuitionPost']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $tuitions = $query->latest()->paginate(15);
        
        return view('tutor.tuitions.index', compact('tuitions'));
    }
    
    /**
     * Show tuition details
     */
    public function show($id)
    {
        $tuition = Tuition::with(['guardian.user', 'tutor.user', 'tuitionPost', 'reviews'])
                          ->where('tutor_id', auth()->user()->tutor->id)
                          ->findOrFail($id);
        
        return view('tutor.tuitions.show', compact('tuition'));
    }
    
    /**
     * Confirm tuition by tutor
     */
    public function confirm($id)
    {
        $tuition = Tuition::where('tutor_id', auth()->user()->tutor->id)
                          ->findOrFail($id);
        
        if ($tuition->tutor_confirmed_at) {
            return back()->with('info', 'You have already confirmed this tuition.');
        }
        
        $tuition->confirmByTutor();
        
        return back()->with('success', 'Tuition confirmed! Waiting for guardian confirmation.');
    }
    
    /**
     * Mark tuition as completed (request completion)
     */
    public function markCompleted($id)
    {
        $tuition = Tuition::where('tutor_id', auth()->user()->tutor->id)
                          ->where('status', 'Active')
                          ->findOrFail($id);
        
        $tuition->update(['status' => 'Pending Completion']);
        
        return back()->with('success', 'Completion request sent. Waiting for guardian confirmation.');
    }
}
