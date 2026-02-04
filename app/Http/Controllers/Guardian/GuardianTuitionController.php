<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Tuition;
use App\Models\Review;
use Illuminate\Http\Request;

class GuardianTuitionController extends Controller
{
    /**
     * Display guardian's tuitions
     */
    public function index(Request $request)
    {
        $query = auth()->user()->guardian->tuitions()
                     ->with(['tutor.user', 'tuitionPost']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $tuitions = $query->latest()->paginate(15);
        
        return view('guardian.tuitions.index', compact('tuitions'));
    }
    
    /**
     * Show tuition details
     */
    public function show($id)
    {
        $tuition = Tuition::with(['tutor.user', 'guardian.user', 'tuitionPost', 'reviews'])
                          ->where('guardian_id', auth()->user()->guardian->id)
                          ->findOrFail($id);
        
        return view('guardian.tuitions.show', compact('tuition'));
    }
    
    /**
     * Confirm tuition by guardian
     */
    public function confirm($id)
    {
        $tuition = Tuition::where('guardian_id', auth()->user()->guardian->id)
                          ->findOrFail($id);
        
        if ($tuition->guardian_confirmed_at) {
            return back()->with('info', 'You have already confirmed this tuition.');
        }
        
        $tuition->confirmByGuardian();
        
        return back()->with('success', 'Tuition confirmed successfully!');
    }
    
    /**
     * Complete tuition (confirm completion)
     */
    public function complete($id)
    {
        $tuition = Tuition::where('guardian_id', auth()->user()->guardian->id)
                          ->findOrFail($id);
        
        if ($tuition->status === 'Completed') {
            return back()->with('info', 'This tuition is already completed.');
        }
        
        $tuition->update([
            'status' => 'Completed',
            'end_date' => now(),
        ]);
        
        return back()->with('success', 'Tuition marked as completed!');
    }
    
    /**
     * Show review form
     */
    public function reviewForm($id)
    {
        $tuition = Tuition::with(['tutor.user'])
                          ->where('guardian_id', auth()->user()->guardian->id)
                          ->where('status', 'Completed')
                          ->findOrFail($id);
        
        // Check if already reviewed
        $existingReview = $tuition->reviews()->where('reviewer_id', auth()->id())->first();
        
        if ($existingReview) {
            return back()->with('info', 'You have already reviewed this tutor.');
        }
        
        return view('guardian.tuitions.review', compact('tuition'));
    }
    
    /**
     * Store review
     */
    public function storeReview(Request $request, $id)
    {
        $tuition = Tuition::where('guardian_id', auth()->user()->guardian->id)
                          ->where('status', 'Completed')
                          ->findOrFail($id);
        
        // Check if already reviewed
        if ($tuition->reviews()->where('reviewer_id', auth()->id())->exists()) {
            return back()->with('error', 'You have already reviewed this tutor.');
        }
        
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:20|max:1000',
        ]);
        
        Review::create([
            'tutor_id' => $tuition->tutor_id,
            'reviewer_id' => auth()->id(),
            'tuition_id' => $tuition->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);
        
        return redirect()->route('guardian.tuitions.show', $tuition->id)
                         ->with('success', 'Review submitted successfully!');
    }
}
