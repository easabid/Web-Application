<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tuition;
use Illuminate\Http\Request;

class CommissionApprovalController extends Controller
{
    /**
     * Display commissions pending approval
     */
    public function index(Request $request)
    {
        $query = Tuition::with(['tutor.user', 'guardian.user', 'tuitionPost.partner.user'])
                       ->where('has_commission', true)
                       ->where('commission_status', 'Pending')
                       ->whereNotNull('admin_verified_at');
        
        $commissions = $query->latest()->paginate(15);
        
        $totalPending = $commissions->sum('commission_amount');
        
        return view('admin.commissions.index', compact('commissions', 'totalPending'));
    }
    
    /**
     * Show commission details
     */
    public function show($id)
    {
        $tuition = Tuition::with(['tutor.user', 'guardian.user', 'tuitionPost.partner.user'])
                          ->where('has_commission', true)
                          ->findOrFail($id);
        
        return view('admin.commissions.show', compact('tuition'));
    }
    
    /**
     * Approve commission
     */
    public function approve($id)
    {
        $tuition = Tuition::where('has_commission', true)
                          ->where('commission_status', 'Pending')
                          ->whereNotNull('admin_verified_at')
                          ->findOrFail($id);
        
        $tuition->approveCommission();
        
        return back()->with('success', 'Commission approved and added to partner balance!');
    }
    
    /**
     * Reject commission
     */
    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10|max:500',
        ]);
        
        $tuition = Tuition::where('has_commission', true)
                          ->where('commission_status', 'Pending')
                          ->findOrFail($id);
        
        $tuition->update([
            'commission_status' => 'Rejected',
            'commission_rejection_reason' => $validated['rejection_reason'],
        ]);
        
        return back()->with('success', 'Commission rejected.');
    }
}
