@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Profile</h1>
            <p class="text-gray-600 mt-1">Update your tutor profile information</p>
        </div>

        <form action="{{ route('tutor.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Basic Information</h2>

                <!-- Current Photo -->
                @if($tutor->photo)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Photo</label>
                        <img src="{{ asset('storage/' . $tutor->photo) }}" alt="Profile Photo" 
                            class="w-24 h-24 rounded-full object-cover">
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Update Photo</label>
                        <input type="file" id="photo" name="photo" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('photo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                        <select id="gender" name="gender" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="Male" {{ $tutor->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $tutor->gender == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" required
                        value="{{ $tutor->date_of_birth->format('Y-m-d') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('date_of_birth')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Full Address</label>
                    <textarea id="address" name="address" rows="3" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $tutor->address }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="area_id" class="block text-sm font-medium text-gray-700 mb-2">Area</label>
                    <select id="area_id" name="area_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}" {{ $tutor->area_id == $area->id ? 'selected' : '' }}>
                                {{ $area->name }} ({{ $area->division }})
                            </option>
                        @endforeach
                    </select>
                    @error('area_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                    <textarea id="bio" name="bio" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Tell us about yourself...">{{ $tutor->bio }}</textarea>
                    @error('bio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Teaching Information -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Teaching Information</h2>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subjects</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-4">
                        @foreach($subjects as $subject)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="subjects[]" value="{{ $subject->id }}"
                                    {{ in_array($subject->id, $tutor->subjects) ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm text-gray-700">{{ $subject->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('subjects')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Class Levels</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-4">
                        @foreach($classLevels as $class)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="class_levels[]" value="{{ $class->id }}"
                                    {{ in_array($class->id, $tutor->class_levels) ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm text-gray-700">{{ $class->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('class_levels')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Areas</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-4">
                        @foreach($areas as $area)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="preferred_areas[]" value="{{ $area->id }}"
                                    {{ in_array($area->id, $tutor->preferred_areas) ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm text-gray-700">{{ $area->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('preferred_areas')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="expected_minimum_salary" class="block text-sm font-medium text-gray-700 mb-2">
                            Expected Minimum Salary (৳)
                        </label>
                        <input type="number" id="expected_minimum_salary" name="expected_minimum_salary" 
                            value="{{ $tutor->expected_minimum_salary }}" required min="500" step="100"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('expected_minimum_salary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="expected_maximum_salary" class="block text-sm font-medium text-gray-700 mb-2">
                            Expected Maximum Salary (৳)
                        </label>
                        <input type="number" id="expected_maximum_salary" name="expected_maximum_salary" 
                            value="{{ $tutor->expected_maximum_salary }}" required min="500" step="100"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('expected_maximum_salary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-between">
                <a href="{{ route('tutor.dashboard') }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
                <button type="submit" 
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
