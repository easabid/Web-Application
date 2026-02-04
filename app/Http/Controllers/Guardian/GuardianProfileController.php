<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Guardian;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GuardianProfileController extends Controller
{
    /**
     * Show profile creation form
     */
    public function create()
    {
        $user = auth()->user();
        
        if ($user->guardian()->exists()) {
            return redirect()->route('guardian.profile.edit');
        }
        
        $areas = Area::where('level', 'Area')->orderBy('name')->get();
        
        return view('guardian.profile.create', compact('areas'));
    }
    
    /**
     * Store guardian profile
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'relation_to_student' => ['required', Rule::in(['Father', 'Mother', 'Guardian', 'Brother', 'Sister', 'Other'])],
            'address' => 'required|string|max:500',
            'area_id' => 'required|exists:areas,id',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);
        
        // Store photo
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('guardians/photos', 'public');
            $validated['photo'] = $photoPath;
        }
        
        // Create guardian profile
        auth()->user()->guardian()->create($validated);
        
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
        $guardian = auth()->user()->guardian;
        
        if (!$guardian) {
            return redirect()->route('guardian.profile.create');
        }
        
        $areas = Area::where('level', 'Area')->orderBy('name')->get();
        
        return view('guardian.profile.edit', compact('guardian', 'areas'));
    }
    
    /**
     * Update existing profile
     */
    public function update(Request $request)
    {
        $guardian = auth()->user()->guardian;
        
        $validated = $request->validate([
            'relation_to_student' => ['required', Rule::in(['Father', 'Mother', 'Guardian', 'Brother', 'Sister', 'Other'])],
            'address' => 'required|string|max:500',
            'area_id' => 'required|exists:areas,id',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($guardian->photo && Storage::disk('public')->exists($guardian->photo)) {
                Storage::disk('public')->delete($guardian->photo);
            }
            $validated['photo'] = $request->file('photo')->store('guardians/photos', 'public');
        }
        
        $guardian->update($validated);
        
        return back()->with('success', 'Profile updated successfully!');
    }
}
