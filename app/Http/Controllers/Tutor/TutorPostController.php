<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\TuitionPost;
use App\Models\Area;
use App\Models\Subject;
use App\Models\ClassLevel;
use Illuminate\Http\Request;

class TutorPostController extends Controller
{
    /**
     * Browse available tuition posts
     */
    public function index(Request $request)
    {
        $query = TuitionPost::query()
            ->with(['guardian.user', 'area', 'partner.user'])
            ->where('status', 'Active')
            ->where('expires_at', '>', now())
            ->whereDoesntHave('applications', function($q) {
                $q->where('tutor_id', auth()->user()->tutor->id);
            });
        
        // Filter by subject
        if ($request->filled('subject_id')) {
            $query->whereJsonContains('preferred_subjects', (int)$request->subject_id);
        }
        
        // Filter by class level
        if ($request->filled('class_level_id')) {
            $query->where('class_level_id', $request->class_level_id);
        }
        
        // Filter by area
        if ($request->filled('area_id')) {
            $query->where('area_id', $request->area_id);
        }
        
        // Filter by gender preference
        if ($request->filled('tutor_gender')) {
            $query->where(function($q) use ($request) {
                $q->where('tutor_gender', $request->tutor_gender)
                  ->orWhere('tutor_gender', 'Any');
            });
        }
        
        // Filter by salary range
        if ($request->filled('min_salary')) {
            $query->where('offered_salary', '>=', $request->min_salary);
        }
        
        if ($request->filled('max_salary')) {
            $query->where('offered_salary', '<=', $request->max_salary);
        }
        
        // Sort
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'salary_high':
                $query->orderBy('offered_salary', 'desc');
                break;
            case 'salary_low':
                $query->orderBy('offered_salary', 'asc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            default: // latest
                $query->latest();
                break;
        }
        
        $posts = $query->paginate(15);
        
        // Filter options
        $subjects = Subject::orderBy('category')->orderBy('name')->get();
        $classLevels = ClassLevel::orderBy('display_order')->get();
        $areas = Area::where('level', 'Area')->orderBy('name')->get();
        
        return view('tutor.posts.index', compact('posts', 'subjects', 'classLevels', 'areas'));
    }
    
    /**
     * Show single post details
     */
    public function show($id)
    {
        $post = TuitionPost::with(['guardian.user', 'area', 'partner.user', 'applications'])
                          ->findOrFail($id);
        
        // Increment view count
        $post->incrementViews();
        
        // Check if tutor has already applied
        $hasApplied = $post->applications()
                           ->where('tutor_id', auth()->user()->tutor->id)
                           ->exists();
        
        // Check if tutor matches preferences
        $tutorProfile = auth()->user()->tutor;
        $matchesGender = $post->tutor_gender === 'Any' || $post->tutor_gender === $tutorProfile->gender;
        
        return view('tutor.posts.show', compact('post', 'hasApplied', 'matchesGender'));
    }
}
