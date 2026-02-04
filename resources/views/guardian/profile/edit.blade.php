@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-3xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Edit Guardian Profile</h2>
            <p class="text-gray-600 mb-6">Update your profile information</p>

            <form action="{{ route('guardian.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Current Photo -->
                @if($guardian->photo)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Photo</label>
                        <img src="{{ asset('storage/' . $guardian->photo) }}" alt="Profile Photo" 
                            class="w-24 h-24 rounded-full object-cover">
                    </div>
                @endif

                <!-- Relation to Student -->
                <div class="mb-6">
                    <label for="relation_to_student" class="block text-sm font-medium text-gray-700 mb-2">
                        Relation to Student <span class="text-red-500">*</span>
                    </label>
                    <select id="relation_to_student" name="relation_to_student" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Select Relation --</option>
                        <option value="Parent" {{ $guardian->relation_to_student == 'Parent' ? 'selected' : '' }}>Parent</option>
                        <option value="Guardian" {{ $guardian->relation_to_student == 'Guardian' ? 'selected' : '' }}>Guardian</option>
                        <option value="Sibling" {{ $guardian->relation_to_student == 'Sibling' ? 'selected' : '' }}>Sibling</option>
                        <option value="Relative" {{ $guardian->relation_to_student == 'Relative' ? 'selected' : '' }}>Relative</option>
                        <option value="Family Friend" {{ $guardian->relation_to_student == 'Family Friend' ? 'selected' : '' }}>Family Friend</option>
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
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $guardian->address }}</textarea>
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
                            <option value="{{ $area->id }}" {{ $guardian->area_id == $area->id ? 'selected' : '' }}>
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
                        Update Profile Photo <span class="text-gray-500 text-xs">(Optional)</span>
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
                    <a href="{{ route('guardian.dashboard') }}" class="text-gray-600 hover:text-gray-800">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
