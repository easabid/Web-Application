<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileApprovalController extends Controller
{
    /**
     * Display pending profile approvals
     */
    public function index(Request $request)
    {
        $query = User::whereNotNull('profile_completed_at')
                    ->whereNull('approved_at')
                    ->whereNull('rejected_at')
                    ->with(['tutor.qualifications', 'tutor.documents', 'guardian', 'partner']);
        
        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        $profiles = $query->latest('profile_completed_at')->paginate(15);
        
        return view('admin.profiles.index', compact('profiles'));
    }
    
    /**
     * Show profile details for review
     */
    public function show($id)
    {
        $user = User::with(['tutor.qualifications', 'tutor.documents', 'tutor.area', 'guardian.area', 'partner'])
                   ->whereNotNull('profile_completed_at')
                   ->findOrFail($id);
        
        return view('admin.profiles.show', compact('user'));
    }
    
    /**
     * Approve a profile
     */
    public function approve($id)
    {
        $user = User::whereNotNull('profile_completed_at')
                   ->whereNull('approved_at')
                   ->findOrFail($id);
        
        $user->update([
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);
        
        // TODO: Send approval email notification
        
        return back()->with('success', 'Profile approved successfully!');
    }
    
    /**
     * Reject a profile
     */
    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10|max:500',
        ]);
        
        $user = User::whereNotNull('profile_completed_at')
                   ->whereNull('approved_at')
                   ->whereNull('rejected_at')
                   ->findOrFail($id);
        
        $user->update([
            'rejected_at' => now(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);
        
        // TODO: Send rejection email notification
        
        return redirect()->route('admin.profiles.index')
                         ->with('success', 'Profile rejected with reason provided.');
    }
}
