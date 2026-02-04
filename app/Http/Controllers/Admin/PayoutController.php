<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionPayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PayoutController extends Controller
{
    /**
     * Display payout requests
     */
    public function index(Request $request)
    {
        $query = CommissionPayout::with(['partner.user', 'items.tuition']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $payouts = $query->latest()->paginate(15);
        
        $stats = [
            'requested' => CommissionPayout::where('status', 'Requested')->sum('net_amount'),
            'approved' => CommissionPayout::where('status', 'Approved')->sum('net_amount'),
            'processing' => CommissionPayout::where('status', 'Processing')->sum('net_amount'),
            'completed' => CommissionPayout::where('status', 'Completed')->sum('net_amount'),
        ];
        
        return view('admin.payouts.index', compact('payouts', 'stats'));
    }
    
    /**
     * Show payout details
     */
    public function show($id)
    {
        $payout = CommissionPayout::with(['partner.user', 'items.tuition.tuitionPost'])
                                  ->findOrFail($id);
        
        return view('admin.payouts.show', compact('payout'));
    }
    
    /**
     * Approve payout
     */
    public function approve($id)
    {
        $payout = CommissionPayout::where('status', 'Requested')
                                  ->findOrFail($id);
        
        $payout->update([
            'status' => 'Approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);
        
        return back()->with('success', 'Payout approved! You can now process the payment.');
    }
    
    /**
     * Mark as processing
     */
    public function process($id)
    {
        $payout = CommissionPayout::where('status', 'Approved')
                                  ->findOrFail($id);
        
        $payout->update([
            'status' => 'Processing',
            'processed_at' => now(),
        ]);
        
        return back()->with('success', 'Payout marked as processing.');
    }
    
    /**
     * Complete payout (upload proof)
     */
    public function complete(Request $request, $id)
    {
        $validated = $request->validate([
            'payment_proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'admin_notes' => 'nullable|string|max:500',
        ]);
        
        $payout = CommissionPayout::whereIn('status', ['Approved', 'Processing'])
                                  ->findOrFail($id);
        
        // Store payment proof
        $proofPath = $request->file('payment_proof')->store('payouts/proofs', 'public');
        
        $payout->update([
            'payment_proof' => $proofPath,
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);
        
        $payout->markAsCompleted();
        
        return back()->with('success', 'Payout completed successfully! Partner balance updated.');
    }
    
    /**
     * Reject payout
     */
    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10|max:500',
        ]);
        
        $payout = CommissionPayout::where('status', 'Requested')
                                  ->findOrFail($id);
        
        $payout->update([
            'status' => 'Rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);
        
        return back()->with('success', 'Payout request rejected.');
    }
}
