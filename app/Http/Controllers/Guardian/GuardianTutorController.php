<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use App\Models\Subject;
use App\Models\ClassLevel;
use App\Models\Area;
use Illuminate\Http\Request;

class GuardianTutorController extends Controller
{
    /**
     * Browse available tutors
     */
    public function index(Request $request)
    {
        $query = Tutor::query()
            ->with(['user', 'area'])
            ->whereHas('user', function($q) {
                $q->where('approved_at', '!=', null)
                  ->whereNull('suspended_at');
            });
        
        // Filter by subject
        if ($request->filled('subject_id')) {
            $query->whereJsonContains('subjects', (int)$request->subject_id);
        }
        
        // Filter by class level
        if ($request->filled('class_level_id')) {
            $query->whereJsonContains('class_levels', (int)$request->class_level_id);
        }
        
        // Filter by area
        if ($request->filled('area_id')) {
            $query->whereJsonContains('preferred_areas', (int)$request->area_id);
        }
        
        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        
        // Filter by salary range
        if ($request->filled('max_salary')) {
            $query->where('expected_minimum_salary', '<=', $request->max_salary);
        }
        
        // Sort
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'rating':
                $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating');
                break;
            case 'experience':
                $query->orderBy('created_at', 'asc');
                break;
            default: // latest
                $query->latest();
                break;
        }
        
        $tutors = $query->paginate(15);
        
        // Filter options
        $subjects = Subject::orderBy('category')->orderBy('name')->get();
        $classLevels = ClassLevel::orderBy('display_order')->get();
        $areas = Area::where('level', 'Area')->orderBy('name')->get();
        
        return view('guardian.tutors.index', compact('tutors', 'subjects', 'classLevels', 'areas'));
    }
    
    /**
     * Show tutor profile
     */
    public function show($id)
    {
        $tutor = Tutor::with(['user', 'area', 'qualifications', 'reviews.reviewer'])
                     ->whereHas('user', function($q) {
                         $q->where('approved_at', '!=', null)
                           ->whereNull('suspended_at');
                     })
                     ->findOrFail($id);
        
        return view('guardian.tutors.show', compact('tutor'));
    }
}
