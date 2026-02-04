@extends('layouts.app')

@section('title', 'Create Profile - Step 1')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="relative">
                        <div class="overflow-hidden h-2 flex rounded bg-gray-200">
                            <div style="width:25%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-600 transition-all duration-500"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-2">
                <span class="text-sm font-medium text-indigo-600">Step 1</span>
                <span class="text-sm text-gray-500">Step 2</span>
                <span class="text-sm text-gray-500">Step 3</span>
                <span class="text-sm text-gray-500">Step 4</span>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Basic Information</h2>
            <p class="text-gray-600 mb-6">Tell us about yourself to get started</p>

            <form method="POST" action="{{ route('tutor.profile.store-step1') }}" enctype="multipart/form-data">
                @csrf

                <!-- Gender -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gender *</label>
                    <div class="flex gap-4">
                        <label class="flex items-center">
                            <input type="radio" name="gender" value="Male" class="mr-2" {{ old('gender') === 'Male' ? 'checked' : '' }} required>
                            <span>Male</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="gender" value="Female" class="mr-2" {{ old('gender') === 'Female' ? 'checked' : '' }}>
                            <span>Female</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="gender" value="Other" class="mr-2" {{ old('gender') === 'Other' ? 'checked' : '' }}>
                            <span>Other</span>
                        </label>
                    </div>
                    @error('gender')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date of Birth -->
                <div class="mb-6">
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth *</label>
                    <input type="date" 
                           id="date_of_birth" 
                           name="date_of_birth" 
                           value="{{ old('date_of_birth') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('date_of_birth') border-red-500 @enderror"
                           required>
                    @error('date_of_birth')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mb-6">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Full Address *</label>
                    <textarea id="address" 
                              name="address" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('address') border-red-500 @enderror"
                              placeholder="House/Flat, Road, Area, District"
                              required>{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Area -->
                <div class="mb-6">
                    <label for="area_id" class="block text-sm font-medium text-gray-700 mb-2">Area *</label>
                    <select id="area_id" 
                            name="area_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('area_id') border-red-500 @enderror"
                            required>
                        <option value="">Select your area</option>
                        @foreach(\App\Models\Area::where('level', 'Area')->orderBy('name')->get() as $area)
                        <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                            {{ $area->name }} ({{ $area->parent->name }})
                        </option>
                        @endforeach
                    </select>
                    @error('area_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bio -->
                <div class="mb-6">
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">About Yourself * (Min 100 characters)</label>
                    <textarea id="bio" 
                              name="bio" 
                              rows="5"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('bio') border-red-500 @enderror"
                              placeholder="Tell guardians about your teaching experience, expertise, and what makes you a great tutor..."
                              required>{{ old('bio') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">{{ strlen(old('bio', '')) }} / 1000 characters</p>
                    @error('bio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photo -->
                <div class="mb-6">
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Profile Photo *</label>
                    <input type="file" 
                           id="photo" 
                           name="photo" 
                           accept="image/jpeg,image/jpg,image/png"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('photo') border-red-500 @enderror"
                           required>
                    <p class="mt-1 text-sm text-gray-500">Max 2MB, JPEG/PNG only</p>
                    @error('photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Next: Teaching Preferences →
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
