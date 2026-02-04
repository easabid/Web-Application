<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\TuitionPost;
use App\Models\Area;
use App\Models\Subject;
use App\Models\ClassLevel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GuardianPostController extends Controller
{
    /**
     * Display guardian's posts
     */
    public function index()
    {
        $posts = auth()->user()->guardian->tuitionPosts()
                    ->with(['area', 'classLevel', 'applications'])
                    ->latest()
                    ->paginate(15);
        
        return view('guardian.posts.index', compact('posts'));
    }
    
    /**
     * Show create post form
     */
    public function create()
    {
        $areas = Area::where('level', 'Area')->orderBy('name')->get();
        $subjects = Subject::orderBy('category')->orderBy('name')->get();
        $classLevels = ClassLevel::orderBy('display_order')->get();
        
        return view('guardian.posts.create', compact('areas', 'subjects', 'classLevels'));
    }
    
    /**
     * Store new post
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_level_id' => 'required|exists:class_levels,id',
            'preferred_subjects' => 'required|array|min:1',
            'preferred_subjects.*' => 'exists:subjects,id',
            'number_of_students' => 'required|integer|min:1|max:10',
            'tuition_type' => ['required', Rule::in(['Home Tutoring', 'Online', 'Both'])],
            'area_id' => 'required|exists:areas,id',
            'student_gender' => ['required', Rule::in(['Male', 'Female', 'Both'])],
            'curriculum' => ['required', Rule::in(['National Curriculum', 'English Version', 'English Medium', 'Cambridge', 'Edexcel', 'IB', 'Madrasa', 'Other'])],
            'preferred_medium' => ['required', Rule::in(['Bangla', 'English', 'Both'])],
            'tutor_gender' => ['required', Rule::in(['Male', 'Female', 'Any'])],
            'days_per_week' => 'required|integer|min:1|max:7',
            'duration' => 'required|numeric|min:0.5|max:8',
            'offered_salary' => 'required|numeric|min:1000|max:100000',
            'requirements' => 'required|string|min:50|max:2000',
        ]);
        
        // Generate post code
        $validated['post_code'] = TuitionPost::generatePostCode();
        $validated['guardian_id'] = auth()->user()->guardian->id;
        $validated['status'] = 'Active';
        
        // Set expiry (30 days from now)
        $expiryDays = config('findtutors.tuition_post_expiry_days', 30);
        $validated['expires_at'] = now()->addDays($expiryDays);
        
        $post = TuitionPost::create($validated);
        
        return redirect()->route('guardian.posts.show', $post->id)
                         ->with('success', 'Tuition post created successfully!');
    }
    
    /**
     * Show single post
     */
    public function show($id)
    {
        $post = TuitionPost::with(['guardian.user', 'area', 'classLevel', 'applications.tutor.user'])
                          ->where('guardian_id', auth()->user()->guardian->id)
                          ->findOrFail($id);
        
        return view('guardian.posts.show', compact('post'));
    }
    
    /**
     * Edit post
     */
    public function edit($id)
    {
        $post = TuitionPost::where('guardian_id', auth()->user()->guardian->id)
                          ->findOrFail($id);
        
        $areas = Area::where('level', 'Area')->orderBy('name')->get();
        $subjects = Subject::orderBy('category')->orderBy('name')->get();
        $classLevels = ClassLevel::orderBy('display_order')->get();
        
        return view('guardian.posts.edit', compact('post', 'areas', 'subjects', 'classLevels'));
    }
    
    /**
     * Update post
     */
    public function update(Request $request, $id)
    {
        $post = TuitionPost::where('guardian_id', auth()->user()->guardian->id)
                          ->findOrFail($id);
        
        $validated = $request->validate([
            'class_level_id' => 'required|exists:class_levels,id',
            'preferred_subjects' => 'required|array|min:1',
            'preferred_subjects.*' => 'exists:subjects,id',
            'number_of_students' => 'required|integer|min:1|max:10',
            'tuition_type' => ['required', Rule::in(['Home Tutoring', 'Online', 'Both'])],
            'area_id' => 'required|exists:areas,id',
            'student_gender' => ['required', Rule::in(['Male', 'Female', 'Both'])],
            'curriculum' => ['required', Rule::in(['National Curriculum', 'English Version', 'English Medium', 'Cambridge', 'Edexcel', 'IB', 'Madrasa', 'Other'])],
            'preferred_medium' => ['required', Rule::in(['Bangla', 'English', 'Both'])],
            'tutor_gender' => ['required', Rule::in(['Male', 'Female', 'Any'])],
            'days_per_week' => 'required|integer|min:1|max:7',
            'duration' => 'required|numeric|min:0.5|max:8',
            'offered_salary' => 'required|numeric|min:1000|max:100000',
            'requirements' => 'required|string|min:50|max:2000',
        ]);
        
        $post->update($validated);
        
        return redirect()->route('guardian.posts.show', $post->id)
                         ->with('success', 'Post updated successfully!');
    }
    
    /**
     * Close/Delete post
     */
    public function destroy($id)
    {
        $post = TuitionPost::where('guardian_id', auth()->user()->guardian->id)
                          ->findOrFail($id);
        
        // Check if post has active tuitions
        if ($post->tuitions()->where('status', 'Active')->exists()) {
            return back()->with('error', 'Cannot delete post with active tuitions.');
        }
        
        $post->update(['status' => 'Closed']);
        
        return redirect()->route('guardian.posts.index')
                         ->with('success', 'Post closed successfully.');
    }
}
