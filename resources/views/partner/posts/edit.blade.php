@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('partner.posts.show', $post->id) }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-2 mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Post
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Edit Commission Post</h1>
            <p class="text-gray-600 mt-1">Update post details and commission</p>
        </div>

        <form action="{{ route('partner.posts.update', $post->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Commission Amount (PRIVATE) -->
            <div class="bg-yellow-50 border-2 border-yellow-300 rounded-lg p-6">
                <div class="flex items-start gap-3 mb-4">
                    <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="text-lg font-bold text-yellow-800">🔒 Private Commission Amount</h3>
                        <p class="text-sm text-yellow-700 mt-1">Only you and admins can see this amount. Not visible to guardians or tutors.</p>
                    </div>
                </div>
                <div>
                    <label for="commission_amount" class="block text-sm font-medium text-gray-700 mb-1">
                        Your Commission <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="commission_amount" id="commission_amount" 
                        value="{{ old('commission_amount', $post->commission_amount) }}" required min="500" max="50000" step="100"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        placeholder="e.g., 2000">
                    @error('commission_amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-600 mt-1">Minimum: ৳500 • Maximum: ৳50,000</p>
                </div>
            </div>

            <!-- Student Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Student Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="class_level_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Class Level <span class="text-red-500">*</span>
                        </label>
                        <select name="class_level_id" id="class_level_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Class</option>
                            @foreach($classLevels as $class)
                                <option value="{{ $class->id }}" {{ old('class_level_id', $post->class_level_id) == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_level_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="student_gender" class="block text-sm font-medium text-gray-700 mb-1">
                            Student Gender <span class="text-red-500">*</span>
                        </label>
                        <select name="student_gender" id="student_gender" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="Male" {{ old('student_gender', $post->student_gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('student_gender', $post->student_gender) == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('student_gender')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="number_of_students" class="block text-sm font-medium text-gray-700 mb-1">
                            Number of Students <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="number_of_students" id="number_of_students" 
                            value="{{ old('number_of_students', $post->number_of_students) }}" required min="1" max="10"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        @error('number_of_students')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="curriculum" class="block text-sm font-medium text-gray-700 mb-1">
                            Curriculum <span class="text-red-500">*</span>
                        </label>
                        <select name="curriculum" id="curriculum" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="Bangla Medium" {{ old('curriculum', $post->curriculum) == 'Bangla Medium' ? 'selected' : '' }}>Bangla Medium</option>
                            <option value="English Medium" {{ old('curriculum', $post->curriculum) == 'English Medium' ? 'selected' : '' }}>English Medium</option>
                            <option value="English Version" {{ old('curriculum', $post->curriculum) == 'English Version' ? 'selected' : '' }}>English Version</option>
                        </select>
                        @error('curriculum')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Subjects <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 max-h-60 overflow-y-auto p-4 border border-gray-300 rounded-lg">
                        @foreach($subjects as $subject)
                            <label class="flex items-center">
                                <input type="checkbox" name="preferred_subjects[]" value="{{ $subject->id }}"
                                    {{ in_array($subject->id, old('preferred_subjects', $post->preferred_subjects)) ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">{{ $subject->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('preferred_subjects')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Tuition Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Tuition Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tuition_type" class="block text-sm font-medium text-gray-700 mb-1">
                            Tuition Type <span class="text-red-500">*</span>
                        </label>
                        <select name="tuition_type" id="tuition_type" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="Home Tutoring" {{ old('tuition_type', $post->tuition_type) == 'Home Tutoring' ? 'selected' : '' }}>Home Tutoring</option>
                            <option value="Online Tutoring" {{ old('tuition_type', $post->tuition_type) == 'Online Tutoring' ? 'selected' : '' }}>Online Tutoring</option>
                            <option value="Coaching Center" {{ old('tuition_type', $post->tuition_type) == 'Coaching Center' ? 'selected' : '' }}>Coaching Center</option>
                        </select>
                        @error('tuition_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="area_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Area <span class="text-red-500">*</span>
                        </label>
                        <select name="area_id" id="area_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Area</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}" {{ old('area_id', $post->area_id) == $area->id ? 'selected' : '' }}>
                                    {{ $area->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('area_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="days_per_week" class="block text-sm font-medium text-gray-700 mb-1">
                            Days Per Week <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="days_per_week" id="days_per_week" 
                            value="{{ old('days_per_week', $post->days_per_week) }}" required min="1" max="7"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        @error('days_per_week')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="duration_in_months" class="block text-sm font-medium text-gray-700 mb-1">
                            Duration (months) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="duration_in_months" id="duration_in_months" 
                            value="{{ old('duration_in_months', $post->duration_in_months) }}" required min="1" max="60"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        @error('duration_in_months')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="offered_salary" class="block text-sm font-medium text-gray-700 mb-1">
                            Offered Salary (per month) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="offered_salary" id="offered_salary" 
                            value="{{ old('offered_salary', $post->offered_salary) }}" required min="500" step="100"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., 5000">
                        @error('offered_salary')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tutor Preferences -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Tutor Preferences</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="preferred_tutor_gender" class="block text-sm font-medium text-gray-700 mb-1">
                            Preferred Gender
                        </label>
                        <select name="preferred_tutor_gender" id="preferred_tutor_gender"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">No Preference</option>
                            <option value="Male" {{ old('preferred_tutor_gender', $post->preferred_tutor_gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('preferred_tutor_gender', $post->preferred_tutor_gender) == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('preferred_tutor_gender')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="preferred_medium" class="block text-sm font-medium text-gray-700 mb-1">
                            Preferred Medium
                        </label>
                        <select name="preferred_medium" id="preferred_medium"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">No Preference</option>
                            <option value="Bangla Medium" {{ old('preferred_medium', $post->preferred_medium) == 'Bangla Medium' ? 'selected' : '' }}>Bangla Medium</option>
                            <option value="English Medium" {{ old('preferred_medium', $post->preferred_medium) == 'English Medium' ? 'selected' : '' }}>English Medium</option>
                        </select>
                        @error('preferred_medium')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="requirements" class="block text-sm font-medium text-gray-700 mb-1">
                            Requirements
                        </label>
                        <textarea name="requirements" id="requirements" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Any specific requirements or instructions">{{ old('requirements', $post->requirements) }}</textarea>
                        @error('requirements')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-4">
                <button type="submit" 
                    class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Update Post
                </button>
                <a href="{{ route('partner.posts.show', $post->id) }}" 
                    class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
