@extends('layouts.app')

@section('title', 'Create Guardian Profile')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-3xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Create Guardian Profile</h2>
            <p class="text-gray-600 mb-6">Please complete your profile to start posting tuition requirements.</p>

            <form action="{{ route('guardian.profile.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Relation to Student -->
                <div class="mb-6">
                    <label for="relation_to_student" class="block text-sm font-medium text-gray-700 mb-2">
                        Relation to Student <span class="text-red-500">*</span>
                    </label>
                    <select id="relation_to_student" name="relation_to_student" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Select Relation --</option>
                        <option value="Parent" {{ old('relation_to_student') == 'Parent' ? 'selected' : '' }}>Parent</option>
                        <option value="Guardian" {{ old('relation_to_student') == 'Guardian' ? 'selected' : '' }}>Guardian</option>
                        <option value="Sibling" {{ old('relation_to_student') == 'Sibling' ? 'selected' : '' }}>Sibling</option>
                        <option value="Relative" {{ old('relation_to_student') == 'Relative' ? 'selected' : '' }}>Relative</option>
                        <option value="Family Friend" {{ old('relation_to_student') == 'Family Friend' ? 'selected' : '' }}>Family Friend</option>
                    </select>
                    @error('relation_to_student')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mb-6">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Address <span class="text-red-500">*</span>
                    </label>
                    <textarea id="address" name="address" rows="3" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter your full address">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Area -->
                <div class="mb-6">
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

                <!-- Photo -->
                <div class="mb-6">
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                        Profile Photo <span class="text-gray-500 text-xs">(Optional)</span>
                    </label>
                    <input type="file" id="photo" name="photo" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-xs text-gray-500">Accepted formats: JPG, PNG, GIF. Max size: 2MB</p>
                    @error('photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between pt-4 border-t">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Create Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
