@extends('layouts.app')

@section('title', 'Create Tuition Post')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Create Tuition Post</h2>
            <p class="text-gray-600 mb-6">Post a tuition requirement with commission on behalf of a guardian.</p>

            <form action="{{ route('partner.posts.store') }}" method="POST">
                @csrf

                <!-- Guardian Selection -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <label for="guardian_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Guardian <span class="text-red-500">*</span>
                    </label>
                    <select id="guardian_id" name="guardian_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Select Guardian --</option>
                        @foreach($guardians as $guardian)
                            <option value="{{ $guardian->id }}" {{ old('guardian_id') == $guardian->id ? 'selected' : '' }}>
                                {{ $guardian->user->full_name }} - {{ $guardian->user->mobile }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-600 mt-1">Select the guardian who is requesting this tuition</p>
                    @error('guardian_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Student Information -->
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Student Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Class Level -->
                        <div>
                            <label for="class_level_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Class Level <span class="text-red-500">*</span>
                            </label>
                            <select id="class_level_id" name="class_level_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Select Class --</option>
                                @foreach($classLevels as $class)
                                    <option value="{{ $class->id }}" {{ old('class_level_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('class_level_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Student Gender -->
                        <div>
                            <label for="student_gender" class="block text-sm font-medium text-gray-700 mb-2">
                                Student Gender <span class="text-red-500">*</span>
                            </label>
                            <select id="student_gender" name="student_gender" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Select Gender --</option>
                                <option value="Male" {{ old('student_gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('student_gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('student_gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Subjects -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Preferred Subjects <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-4">
                            @foreach($subjects as $subject)
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="preferred_subjects[]" value="{{ $subject->id }}"
                                        {{ in_array($subject->id, old('preferred_subjects', [])) ? 'checked' : '' }}
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">{{ $subject->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('preferred_subjects')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Number of Students -->
                        <div>
                            <label for="number_of_students" class="block text-sm font-medium text-gray-700 mb-2">
                                Number of Students <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="number_of_students" name="number_of_students" min="1" max="10"
                                value="{{ old('number_of_students', 1) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('number_of_students')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Curriculum -->
                        <div>
                            <label for="curriculum" class="block text-sm font-medium text-gray-700 mb-2">
                                Curriculum <span class="text-red-500">*</span>
                            </label>
                            <select id="curriculum" name="curriculum" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Select --</option>
                                <option value="Bangla Medium" {{ old('curriculum') == 'Bangla Medium' ? 'selected' : '' }}>Bangla Medium</option>
                                <option value="English Medium" {{ old('curriculum') == 'English Medium' ? 'selected' : '' }}>English Medium</option>
                                <option value="English Version" {{ old('curriculum') == 'English Version' ? 'selected' : '' }}>English Version</option>
                                <option value="Madrasa" {{ old('curriculum') == 'Madrasa' ? 'selected' : '' }}>Madrasa</option>
                            </select>
                            @error('curriculum')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Tuition Details -->
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Tuition Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Tuition Type -->
                        <div>
                            <label for="tuition_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Tuition Type <span class="text-red-500">*</span>
                            </label>
                            <select id="tuition_type" name="tuition_type" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Select Type --</option>
                                <option value="Home" {{ old('tuition_type') == 'Home' ? 'selected' : '' }}>Home Tuition</option>
                                <option value="Online" {{ old('tuition_type') == 'Online' ? 'selected' : '' }}>Online Tuition</option>
                                <option value="Group" {{ old('tuition_type') == 'Group' ? 'selected' : '' }}>Group Tuition</option>
                            </select>
                            @error('tuition_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Area -->
                        <div>
                            <label for="area_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Area <span class="text-red-500">*</span>
                            </label>
                            <select id="area_id" name="area_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Select Area --</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                        {{ $area->name }} ({{ $area->division }})
                                    </option>
                                @endforeach
                            </select>
                            @error('area_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Days per Week -->
                        <div>
                            <label for="days_per_week" class="block text-sm font-medium text-gray-700 mb-2">
                                Days per Week <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="days_per_week" name="days_per_week" min="1" max="7"
                                value="{{ old('days_per_week', 3) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('days_per_week')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                                Duration (minutes) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="duration" name="duration" min="30" max="300" step="15"
                                value="{{ old('duration', 60) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('duration')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Offered Salary -->
                        <div>
                            <label for="offered_salary" class="block text-sm font-medium text-gray-700 mb-2">
                                Offered Salary (৳) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="offered_salary" name="offered_salary" min="500" step="100"
                                value="{{ old('offered_salary') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('offered_salary')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Tutor Preferences -->
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Tutor Preferences</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tutor Gender -->
                        <div>
                            <label for="tutor_gender" class="block text-sm font-medium text-gray-700 mb-2">
                                Preferred Tutor Gender
                            </label>
                            <select id="tutor_gender" name="tutor_gender"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">No Preference</option>
                                <option value="Male" {{ old('tutor_gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('tutor_gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('tutor_gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preferred Medium -->
                        <div>
                            <label for="preferred_medium" class="block text-sm font-medium text-gray-700 mb-2">
                                Preferred Medium
                            </label>
                            <select id="preferred_medium" name="preferred_medium"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">No Preference</option>
                                <option value="Bangla" {{ old('preferred_medium') == 'Bangla' ? 'selected' : '' }}>Bangla</option>
                                <option value="English" {{ old('preferred_medium') == 'English' ? 'selected' : '' }}>English</option>
                                <option value="Both" {{ old('preferred_medium') == 'Both' ? 'selected' : '' }}>Both</option>
                            </select>
                            @error('preferred_medium')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Commission Amount (PRIVATE) -->
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">
                            <span class="text-yellow-600">🔒</span> Commission Amount (Private)
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">This information is only visible to you and admins.</p>
                        
                        <div class="max-w-sm">
                            <label for="commission_amount" class="block text-sm font-medium text-gray-700 mb-2">
                                Commission Amount (৳) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="commission_amount" name="commission_amount" 
                                min="500" max="50000" step="100"
                                value="{{ old('commission_amount') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Minimum: ৳500 | Maximum: ৳50,000</p>
                            @error('commission_amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Requirements -->
                <div class="mb-6">
                    <label for="requirements" class="block text-sm font-medium text-gray-700 mb-2">
                        Additional Requirements
                    </label>
                    <textarea id="requirements" name="requirements" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Any specific requirements or expectations...">{{ old('requirements') }}</textarea>
                    @error('requirements')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-between pt-4 border-t">
                    <a href="{{ route('partner.posts.index') }}" class="text-gray-600 hover:text-gray-800">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Create Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
