<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Tuition;
use Illuminate\Http\Request;

class PartnerEarningsController extends Controller
{
    /**
     * Display earnings overview and commission-eligible tuitions
     */
    public function index(Request $request)
    {
        $partner = auth()->user()->partner;
        
        // Get tuitions with commission tracking
        $query = $partner->tuitions()
                        ->with(['tutor.user', 'guardian.user', 'tuitionPost'])
                        ->where('has_commission', true);
        
        // Filter by commission status
        if ($request->filled('commission_status')) {
            $query->where('commission_status', $request->commission_status);
        }
        
        $tuitions = $query->latest()->paginate(15);
        
        // Earnings summary
        $summary = [
            'pending_approval' => $partner->tuitions()
                                          ->where('has_commission', true)
                                          ->where('commission_status', 'Pending')
                                          ->sum('commission_amount'),
            'approved' => $partner->tuitions()
                                 ->where('has_commission', true)
                                 ->where('commission_status', 'Approved')
                                 ->sum('commission_amount'),
            'paid' => $partner->tuitions()
                             ->where('has_commission', true)
                             ->where('commission_status', 'Paid')
                             ->sum('commission_amount'),
            'pending_payout' => $partner->pending_payout,
        ];
        
        return view('partner.earnings.index', compact('tuitions', 'summary'));
    }
    
    /**
     * Show earnings details
     */
    public function show($id)
    {
        $tuition = Tuition::with(['tutor.user', 'guardian.user', 'tuitionPost'])
                          ->whereHas('tuitionPost', function($q) {
                              $q->where('partner_id', auth()->user()->partner->id);
                          })
                          ->where('has_commission', true)
                          ->findOrFail($id);
        
        return view('partner.earnings.show', compact('tuition'));
    }
}
