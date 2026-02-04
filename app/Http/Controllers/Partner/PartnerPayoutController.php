<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\CommissionPayout;
use Illuminate\Http\Request;

class PartnerPayoutController extends Controller
{
    /**
     * Display payout history and request form
     */
    public function index()
    {
        $partner = auth()->user()->partner;
        
        $payouts = $partner->payouts()
                          ->with('items.tuition.tuitionPost')
                          ->latest()
                          ->paginate(15);
        
        // Calculate available for payout
        $minPayoutAmount = config('findtutors.minimum_payout_amount', 1000);
        $canRequestPayout = $partner->pending_payout >= $minPayoutAmount;
        
        return view('partner.payouts.index', compact('payouts', 'partner', 'minPayoutAmount', 'canRequestPayout'));
    }
    
    /**
     * Request new payout
     */
    public function create()
    {
        $partner = auth()->user()->partner;
        $minPayoutAmount = config('findtutors.minimum_payout_amount', 1000);
        
        if ($partner->pending_payout < $minPayoutAmount) {
            return back()->with('error', "Minimum payout amount is ৳{$minPayoutAmount}. Your current balance is ৳{$partner->pending_payout}.");
        }
        
        // Get approved but unpaid commissions
        $eligibleTuitions = $partner->tuitions()
                                   ->where('has_commission', true)
                                   ->where('commission_status', 'Approved')
                                   ->whereDoesntHave('commissionPayoutItems')
                                   ->with('tuitionPost')
                                   ->get();
        
        if ($eligibleTuitions->isEmpty()) {
            return back()->with('error', 'No approved commissions available for payout.');
        }
        
        return view('partner.payouts.create', compact('eligibleTuitions', 'partner'));
    }
    
    /**
     * Store payout request
     */
    public function store(Request $request)
    {
        $partner = auth()->user()->partner;
        $minPayoutAmount = config('findtutors.minimum_payout_amount', 1000);
        
        if ($partner->pending_payout < $minPayoutAmount) {
            return back()->with('error', "Insufficient balance for payout.");
        }
        
        $validated = $request->validate([
            'tuition_ids' => 'required|array|min:1',
            'tuition_ids.*' => 'exists:tuitions,id',
            'notes' => 'nullable|string|max:500',
        ]);
        
        // Verify tuitions belong to partner and are eligible
        $tuitions = $partner->tuitions()
                           ->where('has_commission', true)
                           ->where('commission_status', 'Approved')
                           ->whereDoesntHave('commissionPayoutItems')
                           ->whereIn('id', $validated['tuition_ids'])
                           ->get();
        
        if ($tuitions->isEmpty()) {
            return back()->with('error', 'No eligible tuitions selected.');
        }
        
        // Calculate total
        $grossAmount = $tuitions->sum('commission_amount');
        
        // Create payout request
        $payout = CommissionPayout::create([
            'partner_id' => $partner->id,
            'gross_amount' => $grossAmount,
            'platform_fee_percentage' => config('findtutors.platform_fee_percentage', 10),
            'status' => 'Requested',
            'payment_method' => $partner->payment_method,
            'payment_details' => $partner->payment_details,
            'notes' => $validated['notes'] ?? null,
        ]);
        
        // Calculate fees
        $payout->calculateFees();
        
        // Attach tuitions
        foreach ($tuitions as $tuition) {
            $payout->items()->create([
                'tuition_id' => $tuition->id,
                'commission_amount' => $tuition->commission_amount,
            ]);
        }
        
        return redirect()->route('partner.payouts.index')
                         ->with('success', 'Payout request submitted successfully! Awaiting admin approval.');
    }
    
    /**
     * Show payout details
     */
    public function show($id)
    {
        $payout = CommissionPayout::with(['partner.user', 'items.tuition.tuitionPost'])
                                  ->where('partner_id', auth()->user()->partner->id)
                                  ->findOrFail($id);
        
        return view('partner.payouts.show', compact('payout'));
    }
}
