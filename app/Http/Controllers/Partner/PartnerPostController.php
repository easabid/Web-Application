<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\TuitionPost;
use App\Models\Area;
use App\Models\Subject;
use App\Models\ClassLevel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PartnerPostController extends Controller
{
    /**
     * Display partner's posts
     */
    public function index()
    {
        $posts = auth()->user()->partner->tuitionPosts()
                    ->with(['area', 'classLevel', 'applications', 'guardian.user'])
                    ->latest()
                    ->paginate(15);
        
        return view('partner.posts.index', compact('posts'));
    }
    
    /**
     * Show create post form
     */
    public function create()
    {
        $areas = Area::where('level', 'Area')->orderBy('name')->get();
        $subjects = Subject::orderBy('category')->orderBy('name')->get();
        $classLevels = ClassLevel::orderBy('display_order')->get();
        
        return view('partner.posts.create', compact('areas', 'subjects', 'classLevels'));
    }
    
    /**
     * Store new post (WITH commission)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'guardian_id' => 'required|exists:guardians,id',
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
            'commission_amount' => 'required|numeric|min:500|max:50000', // PRIVATE field
            'requirements' => 'required|string|min:50|max:2000',
        ]);
        
        // Generate post code
        $validated['post_code'] = TuitionPost::generatePostCode();
        $validated['partner_id'] = auth()->user()->partner->id;
        $validated['status'] = 'Active';
        
        // Set expiry
        $expiryDays = config('findtutors.tuition_post_expiry_days', 30);
        $validated['expires_at'] = now()->addDays($expiryDays);
        
        $post = TuitionPost::create($validated);
        
        return redirect()->route('partner.posts.show', $post->id)
                         ->with('success', 'Tuition post created successfully with commission tracking!');
    }
    
    /**
     * Show single post
     */
    public function show($id)
    {
        $post = TuitionPost::with(['partner.user', 'guardian.user', 'area', 'classLevel', 'applications.tutor.user'])
                          ->where('partner_id', auth()->user()->partner->id)
                          ->findOrFail($id);
        
        return view('partner.posts.show', compact('post'));
    }
    
    /**
     * Edit post
     */
    public function edit($id)
    {
        $post = TuitionPost::where('partner_id', auth()->user()->partner->id)
                          ->findOrFail($id);
        
        $areas = Area::where('level', 'Area')->orderBy('name')->get();
        $subjects = Subject::orderBy('category')->orderBy('name')->get();
        $classLevels = ClassLevel::orderBy('display_order')->get();
        
        return view('partner.posts.edit', compact('post', 'areas', 'subjects', 'classLevels'));
    }
    
    /**
     * Update post
     */
    public function update(Request $request, $id)
    {
        $post = TuitionPost::where('partner_id', auth()->user()->partner->id)
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
            'commission_amount' => 'required|numeric|min:500|max:50000',
            'requirements' => 'required|string|min:50|max:2000',
        ]);
        
        $post->update($validated);
        
        return redirect()->route('partner.posts.show', $post->id)
                         ->with('success', 'Post updated successfully!');
    }
    
    /**
     * Close post
     */
    public function destroy($id)
    {
        $post = TuitionPost::where('partner_id', auth()->user()->partner->id)
                          ->findOrFail($id);
        
        if ($post->tuitions()->where('status', 'Active')->exists()) {
            return back()->with('error', 'Cannot close post with active tuitions.');
        }
        
        $post->update(['status' => 'Closed']);
        
        return redirect()->route('partner.posts.index')
                         ->with('success', 'Post closed successfully.');
    }
}
