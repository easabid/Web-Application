<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tuition;
use Illuminate\Http\Request;

class TuitionVerificationController extends Controller
{
    /**
     * Display tuitions pending verification
     */
    public function index(Request $request)
    {
        $query = Tuition::with(['tutor.user', 'guardian.user', 'tuitionPost'])
                       ->where('status', 'Pending')
                       ->whereNotNull('tutor_confirmed_at')
                       ->whereNotNull('guardian_confirmed_at');
        
        // Filter by commission
        if ($request->filled('has_commission')) {
            $query->where('has_commission', $request->has_commission);
        }
        
        $tuitions = $query->latest()->paginate(15);
        
        return view('admin.tuitions.index', compact('tuitions'));
    }
    
    /**
     * Show tuition details
     */
    public function show($id)
    {
        $tuition = Tuition::with(['tutor.user', 'tutor.qualifications', 'guardian.user', 'tuitionPost.partner.user'])
                          ->findOrFail($id);
        
        return view('admin.tuitions.show', compact('tuition'));
    }
    
    /**
     * Verify and activate tuition
     */
    public function verify($id)
    {
        $tuition = Tuition::where('status', 'Pending')
                          ->whereNotNull('tutor_confirmed_at')
                          ->whereNotNull('guardian_confirmed_at')
                          ->findOrFail($id);
        
        $tuition->verifyByAdmin();
        
        return back()->with('success', 'Tuition verified and activated successfully!');
    }
    
    /**
     * Reject tuition
     */
    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10|max:500',
        ]);
        
        $tuition = Tuition::findOrFail($id);
        
        $tuition->update([
            'status' => 'Cancelled',
            'rejection_reason' => $validated['rejection_reason'],
        ]);
        
        return back()->with('success', 'Tuition rejected.');
    }
}
