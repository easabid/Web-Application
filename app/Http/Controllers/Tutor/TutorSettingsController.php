<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class TutorSettingsController extends Controller
{
    /**
     * Show settings page
     */
    public function index()
    {
        $user = auth()->user();
        return view('tutor.settings.index', compact('user'));
    }
    
    /**
     * Update account information
     */
    public function updateAccount(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'mobile' => 'required|string|max:20|unique:users,mobile,' . auth()->id(),
        ]);
        
        auth()->user()->update($validated);
        
        return back()->with('success', 'Account information updated successfully!');
    }
    
    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        
        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return back()->with('success', 'Password updated successfully!');
    }
    
    /**
     * Update notification preferences
     */
    public function updateNotifications(Request $request)
    {
        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
        ]);
        
        // Store preferences (you can add notification preference columns to users table)
        auth()->user()->update($validated);
        
        return back()->with('success', 'Notification preferences updated!');
    }
}
