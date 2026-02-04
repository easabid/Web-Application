@extends('layouts.app')

@section('title', 'Create Profile - Step 2')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="relative">
                        <div class="overflow-hidden h-2 flex rounded bg-gray-200">
                            <div style="width:50%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-600 transition-all duration-500"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-2">
                <span class="text-sm text-gray-500">Step 1</span>
                <span class="text-sm font-medium text-indigo-600">Step 2</span>
                <span class="text-sm text-gray-500">Step 3</span>
                <span class="text-sm text-gray-500">Step 4</span>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Teaching Preferences</h2>
            <p class="text-gray-600 mb-6">Select your teaching subjects, classes, and availability</p>

            <form method="POST" action="{{ route('tutor.profile.store-step2') }}">
                @csrf

                <!-- Subjects -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subjects You Can Teach * (Max 10)</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-64 overflow-y-auto border border-gray-200 rounded-lg p-4">
                        @foreach($subjects->groupBy('category') as $category => $categorySubjects)
                        <div class="col-span-full">
                            <h4 class="font-semibold text-gray-700 text-sm mb-2">{{ $category }}</h4>
                        </div>
                        @foreach($categorySubjects as $subject)
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded">
                            <input type="checkbox" 
                                   name="subjects[]" 
                                   value="{{ $subject->id }}"
                                   class="mr-2"
                                   {{ in_array($subject->id, old('subjects', [])) ? 'checked' : '' }}>
                            <span class="text-sm">{{ $subject->name_bn }}</span>
                        </label>
                        @endforeach
                        @endforeach
                    </div>
                    @error('subjects')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Class Levels -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Classes You Can Teach * (Max 10)</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach($classLevels as $level)
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded border border-gray-200">
                            <input type="checkbox" 
                                   name="class_levels[]" 
                                   value="{{ $level->id }}"
                                   class="mr-2"
                                   {{ in_array($level->id, old('class_levels', [])) ? 'checked' : '' }}>
                            <span class="text-sm">{{ $level->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('class_levels')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preferred Areas -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Teaching Areas * (Max 5)</label>
                    <select name="preferred_areas[]" 
                            multiple 
                            size="8"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('preferred_areas') border-red-500 @enderror">
                        @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ in_array($area->id, old('preferred_areas', [])) ? 'selected' : '' }}>
                            {{ $area->name }} ({{ $area->parent->name }})
                        </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Hold Ctrl (Windows) or Cmd (Mac) to select multiple</p>
                    @error('preferred_areas')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Salary Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="expected_minimum_salary" class="block text-sm font-medium text-gray-700 mb-2">Minimum Expected Salary (৳/month) *</label>
                        <input type="number" 
                               id="expected_minimum_salary" 
                               name="expected_minimum_salary" 
                               value="{{ old('expected_minimum_salary') }}"
                               min="1000"
                               step="100"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('expected_minimum_salary') border-red-500 @enderror"
                               placeholder="5000"
                               required>
                        @error('expected_minimum_salary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="expected_maximum_salary" class="block text-sm font-medium text-gray-700 mb-2">Maximum Expected Salary (৳/month) *</label>
                        <input type="number" 
                               id="expected_maximum_salary" 
                               name="expected_maximum_salary" 
                               value="{{ old('expected_maximum_salary') }}"
                               min="1000"
                               step="100"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('expected_maximum_salary') border-red-500 @enderror"
                               placeholder="10000"
                               required>
                        @error('expected_maximum_salary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Available Days -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Available Days *</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach(['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded border border-gray-200">
                            <input type="checkbox" 
                                   name="available_days[]" 
                                   value="{{ $day }}"
                                   class="mr-2"
                                   {{ in_array($day, old('available_days', [])) ? 'checked' : '' }}>
                            <span class="text-sm">{{ $day }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('available_days')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Available Time -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Available Time *</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach(['Morning', 'Afternoon', 'Evening', 'Night'] as $time)
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded border border-gray-200">
                            <input type="checkbox" 
                                   name="available_time[]" 
                                   value="{{ $time }}"
                                   class="mr-2"
                                   {{ in_array($time, old('available_time', [])) ? 'checked' : '' }}>
                            <span class="text-sm">{{ $time }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('available_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-between">
                    <a href="{{ route('tutor.profile.create') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition">
                        ← Previous
                    </a>
                    <button type="submit" 
                            class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Next: Qualifications →
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
