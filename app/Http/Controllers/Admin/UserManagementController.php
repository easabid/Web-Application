<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    /**
     * Display all users
     */
    public function index(Request $request)
    {
        $query = User::with(['tutor', 'guardian', 'partner']);
        
        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'approved':
                    $query->whereNotNull('approved_at');
                    break;
                case 'pending':
                    $query->whereNotNull('profile_completed_at')
                          ->whereNull('approved_at')
                          ->whereNull('rejected_at');
                    break;
                case 'rejected':
                    $query->whereNotNull('rejected_at');
                    break;
                case 'suspended':
                    $query->whereNotNull('suspended_at');
                    break;
            }
        }
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%");
            });
        }
        
        $users = $query->latest()->paginate(20);
        
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Show user details
     */
    public function show($id)
    {
        $user = User::with(['tutor.qualifications', 'tutor.documents', 'tutor.applications', 'tutor.tuitions',
                           'guardian.tuitionPosts', 'guardian.tuitions',
                           'partner.tuitionPosts', 'partner.tuitions', 'partner.payouts'])
                   ->findOrFail($id);
        
        return view('admin.users.show', compact('user'));
    }
    
    /**
     * Suspend a user
     */
    public function suspend(Request $request, $id)
    {
        $validated = $request->validate([
            'suspension_reason' => 'required|string|min:10|max:500',
        ]);
        
        $user = User::findOrFail($id);
        
        $user->update([
            'suspended_at' => now(),
            'suspension_reason' => $validated['suspension_reason'],
        ]);
        
        return back()->with('success', 'User suspended successfully.');
    }
    
    /**
     * Unsuspend a user
     */
    public function unsuspend($id)
    {
        $user = User::findOrFail($id);
        
        $user->update([
            'suspended_at' => null,
            'suspension_reason' => null,
        ]);
        
        return back()->with('success', 'User unsuspended successfully.');
    }
    
    /**
     * Delete a user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Check if user has active tuitions
        if ($user->isTutor() && $user->tutor->tuitions()->where('status', 'Active')->exists()) {
            return back()->with('error', 'Cannot delete user with active tuitions.');
        }
        
        if ($user->isGuardian() && $user->guardian->tuitions()->where('status', 'Active')->exists()) {
            return back()->with('error', 'Cannot delete user with active tuitions.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
                         ->with('success', 'User deleted successfully.');
    }
}
