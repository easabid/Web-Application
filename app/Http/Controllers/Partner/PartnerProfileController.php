<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\TuitionPartner;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerProfileController extends Controller
{
    /**
     * Show profile creation form
     */
    public function create()
    {
        $user = auth()->user();
        
        if ($user->partner()->exists()) {
            return redirect()->route('partner.profile.edit');
        }
        
        $areas = Area::where('level', 'Area')->orderBy('name')->get();
        
        return view('partner.profile.create', compact('areas'));
    }
    
    /**
     * Store partner profile
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_name' => 'nullable|string|max:200',
            'address' => 'required|string|max:500',
            'coverage_areas' => 'required|array|min:1|max:10',
            'coverage_areas.*' => 'exists:areas,id',
            'payment_method' => 'required|in:Bank Transfer,bKash,Nagad,Rocket',
            'payment_details' => 'required|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);
        
        // Store photo
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('partners/photos', 'public');
            $validated['photo'] = $photoPath;
        }
        
        // Generate unique referral code
        $validated['referral_code'] = TuitionPartner::generateReferralCode();
        
        // Create partner profile
        auth()->user()->partner()->create($validated);
        
        // Mark profile as complete
        auth()->user()->update([
            'profile_completed_at' => now(),
        ]);
        
        return redirect()->route('profile.pending')
                         ->with('success', 'Your profile has been submitted for review!');
    }
    
    /**
     * Edit existing profile
     */
    public function edit()
    {
        $partner = auth()->user()->partner;
        
        if (!$partner) {
            return redirect()->route('partner.profile.create');
        }
        
        $areas = Area::where('level', 'Area')->orderBy('name')->get();
        
        return view('partner.profile.edit', compact('partner', 'areas'));
    }
    
    /**
     * Update existing profile
     */
    public function update(Request $request)
    {
        $partner = auth()->user()->partner;
        
        $validated = $request->validate([
            'organization_name' => 'nullable|string|max:200',
            'address' => 'required|string|max:500',
            'coverage_areas' => 'required|array|min:1|max:10',
            'coverage_areas.*' => 'exists:areas,id',
            'payment_method' => 'required|in:Bank Transfer,bKash,Nagad,Rocket',
            'payment_details' => 'required|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($partner->photo && Storage::disk('public')->exists($partner->photo)) {
                Storage::disk('public')->delete($partner->photo);
            }
            $validated['photo'] = $request->file('photo')->store('partners/photos', 'public');
        }
        
        $partner->update($validated);
        
        return back()->with('success', 'Profile updated successfully!');
    }
}
