<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\ClassLevel;
use App\Models\Subject;
use App\Models\Tutor;
use App\Models\TutorQualification;
use App\Models\TutorDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TutorProfileController extends Controller
{
    /**
     * Show profile creation form - Step 1: Basic Info
     */
    public function create()
    {
        $user = auth()->user();
        
        // Check if profile already exists
        if ($user->tutor()->exists()) {
            return redirect()->route('tutor.profile.edit');
        }
        
        return view('tutor.profile.create-step1');
    }
    
    /**
     * Store Step 1: Basic Info
     */
    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'gender' => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'date_of_birth' => 'required|date|before:today|after:1950-01-01',
            'address' => 'required|string|max:500',
            'area_id' => 'required|exists:areas,id',
            'bio' => 'required|string|min:100|max:1000',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);
        
        // Store photo
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('tutors/photos', 'public');
            $validated['photo'] = $photoPath;
        }
        
        // Create tutor profile
        $tutor = auth()->user()->tutor()->create([
            'gender' => $validated['gender'],
            'date_of_birth' => $validated['date_of_birth'],
            'address' => $validated['address'],
            'area_id' => $validated['area_id'],
            'bio' => $validated['bio'],
            'photo' => $validated['photo'] ?? null,
        ]);
        
        return redirect()->route('tutor.profile.create-step2')
                         ->with('success', 'Basic information saved! Please continue with teaching preferences.');
    }
    
    /**
     * Show Step 2: Teaching Preferences
     */
    public function createStep2()
    {
        $user = auth()->user();
        
        if (!$user->tutor()->exists()) {
            return redirect()->route('tutor.profile.create')
                             ->with('error', 'Please complete Step 1 first.');
        }
        
        $subjects = Subject::orderBy('category')->orderBy('name')->get();
        $classLevels = ClassLevel::orderBy('display_order')->get();
        $areas = Area::where('level', 'Area')->orderBy('name')->get();
        
        return view('tutor.profile.create-step2', compact('subjects', 'classLevels', 'areas'));
    }
    
    /**
     * Store Step 2: Teaching Preferences
     */
    public function storeStep2(Request $request)
    {
        $validated = $request->validate([
            'subjects' => 'required|array|min:1|max:10',
            'subjects.*' => 'exists:subjects,id',
            'class_levels' => 'required|array|min:1|max:10',
            'class_levels.*' => 'exists:class_levels,id',
            'preferred_areas' => 'required|array|min:1|max:5',
            'preferred_areas.*' => 'exists:areas,id',
            'expected_minimum_salary' => 'required|numeric|min:1000|max:100000',
            'expected_maximum_salary' => 'required|numeric|min:1000|max:100000|gte:expected_minimum_salary',
            'available_days' => 'required|array|min:1',
            'available_days.*' => Rule::in(['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            'available_time' => 'required|array|min:1',
            'available_time.*' => Rule::in(['Morning', 'Afternoon', 'Evening', 'Night']),
        ]);
        
        $tutor = auth()->user()->tutor;
        $tutor->update([
            'subjects' => $validated['subjects'],
            'class_levels' => $validated['class_levels'],
            'preferred_areas' => $validated['preferred_areas'],
            'expected_minimum_salary' => $validated['expected_minimum_salary'],
            'expected_maximum_salary' => $validated['expected_maximum_salary'],
            'available_days' => $validated['available_days'],
            'available_time' => $validated['available_time'],
        ]);
        
        return redirect()->route('tutor.profile.create-step3')
                         ->with('success', 'Teaching preferences saved! Please add your qualifications.');
    }
    
    /**
     * Show Step 3: Qualifications
     */
    public function createStep3()
    {
        $user = auth()->user();
        
        if (!$user->tutor()->exists()) {
            return redirect()->route('tutor.profile.create')
                             ->with('error', 'Please complete Step 1 first.');
        }
        
        $qualifications = $user->tutor->qualifications;
        
        return view('tutor.profile.create-step3', compact('qualifications'));
    }
    
    /**
     * Store Step 3: Add Qualification
     */
    public function storeQualification(Request $request)
    {
        $validated = $request->validate([
            'level' => ['required', Rule::in(['SSC', 'HSC', 'Bachelors', 'Masters', 'Others'])],
            'degree_title' => 'required|string|max:200',
            'institution' => 'required|string|max:200',
            'subject' => 'nullable|string|max:200',
            'passing_year' => 'required|numeric|min:1980|max:' . date('Y'),
            'result' => 'required|string|max:50',
        ]);
        
        auth()->user()->tutor->qualifications()->create($validated);
        
        return back()->with('success', 'Qualification added successfully!');
    }
    
    /**
     * Delete Qualification
     */
    public function deleteQualification($id)
    {
        $qualification = TutorQualification::where('tutor_id', auth()->user()->tutor->id)
                                          ->where('id', $id)
                                          ->firstOrFail();
        
        $qualification->delete();
        
        return back()->with('success', 'Qualification deleted successfully!');
    }
    
    /**
     * Continue to Step 4
     */
    public function continueToStep4()
    {
        $tutor = auth()->user()->tutor;
        
        // Ensure at least one qualification exists
        if ($tutor->qualifications()->count() < 1) {
            return back()->with('error', 'Please add at least one qualification before continuing.');
        }
        
        return redirect()->route('tutor.profile.create-step4');
    }
    
    /**
     * Show Step 4: Documents
     */
    public function createStep4()
    {
        $user = auth()->user();
        
        if (!$user->tutor()->exists()) {
            return redirect()->route('tutor.profile.create')
                             ->with('error', 'Please complete Step 1 first.');
        }
        
        if ($user->tutor->qualifications()->count() < 1) {
            return redirect()->route('tutor.profile.create-step3')
                             ->with('error', 'Please add at least one qualification first.');
        }
        
        $documents = $user->tutor->documents;
        
        return view('tutor.profile.create-step4', compact('documents'));
    }
    
    /**
     * Store Step 4: Upload Document
     */
    public function storeDocument(Request $request)
    {
        $validated = $request->validate([
            'document_type' => ['required', Rule::in(['NID', 'Passport', 'Birth Certificate', 'Student ID', 'Educational Certificate', 'Other'])],
            'document_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);
        
        // Store document file
        $filePath = $request->file('document_file')->store('tutors/documents', 'public');
        
        auth()->user()->tutor->documents()->create([
            'document_type' => $validated['document_type'],
            'document_path' => $filePath,
        ]);
        
        return back()->with('success', 'Document uploaded successfully!');
    }
    
    /**
     * Delete Document
     */
    public function deleteDocument($id)
    {
        $document = TutorDocument::where('tutor_id', auth()->user()->tutor->id)
                                 ->where('id', $id)
                                 ->firstOrFail();
        
        // Delete file from storage
        if (Storage::disk('public')->exists($document->document_path)) {
            Storage::disk('public')->delete($document->document_path);
        }
        
        $document->delete();
        
        return back()->with('success', 'Document deleted successfully!');
    }
    
    /**
     * Submit Profile for Review
     */
    public function submitProfile()
    {
        $tutor = auth()->user()->tutor;
        
        // Validate profile is complete
        if (!$tutor) {
            return redirect()->route('tutor.profile.create')
                             ->with('error', 'Please complete your profile first.');
        }
        
        if ($tutor->qualifications()->count() < 1) {
            return redirect()->route('tutor.profile.create-step3')
                             ->with('error', 'Please add at least one qualification.');
        }
        
        if ($tutor->documents()->count() < 1) {
            return redirect()->route('tutor.profile.create-step4')
                             ->with('error', 'Please upload at least one verification document.');
        }
        
        // Mark user as profile complete (waiting for approval)
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
        $tutor = auth()->user()->tutor;
        
        if (!$tutor) {
            return redirect()->route('tutor.profile.create');
        }
        
        $subjects = Subject::orderBy('category')->orderBy('name')->get();
        $classLevels = ClassLevel::orderBy('display_order')->get();
        $areas = Area::where('level', 'Area')->orderBy('name')->get();
        $qualifications = $tutor->qualifications;
        $documents = $tutor->documents;
        
        return view('tutor.profile.edit', compact('tutor', 'subjects', 'classLevels', 'areas', 'qualifications', 'documents'));
    }
    
    /**
     * Update existing profile
     */
    public function update(Request $request)
    {
        $tutor = auth()->user()->tutor;
        
        $validated = $request->validate([
            'gender' => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'date_of_birth' => 'required|date|before:today|after:1950-01-01',
            'address' => 'required|string|max:500',
            'area_id' => 'required|exists:areas,id',
            'bio' => 'required|string|min:100|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'subjects' => 'required|array|min:1|max:10',
            'subjects.*' => 'exists:subjects,id',
            'class_levels' => 'required|array|min:1|max:10',
            'class_levels.*' => 'exists:class_levels,id',
            'preferred_areas' => 'required|array|min:1|max:5',
            'preferred_areas.*' => 'exists:areas,id',
            'expected_minimum_salary' => 'required|numeric|min:1000|max:100000',
            'expected_maximum_salary' => 'required|numeric|min:1000|max:100000|gte:expected_minimum_salary',
            'available_days' => 'required|array|min:1',
            'available_days.*' => Rule::in(['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            'available_time' => 'required|array|min:1',
            'available_time.*' => Rule::in(['Morning', 'Afternoon', 'Evening', 'Night']),
        ]);
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($tutor->photo && Storage::disk('public')->exists($tutor->photo)) {
                Storage::disk('public')->delete($tutor->photo);
            }
            $validated['photo'] = $request->file('photo')->store('tutors/photos', 'public');
        }
        
        $tutor->update($validated);
        
        return back()->with('success', 'Profile updated successfully!');
    }
}
