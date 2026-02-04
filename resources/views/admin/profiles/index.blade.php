@extends('layouts.app')

@section('title', 'Profile Approvals')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Profile Approvals</h1>
                <p class="text-gray-600 mt-1">Review and approve user profiles</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('admin.profiles.index') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">User Type</label>
                    <select name="type" id="type" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Types</option>
                        <option value="3" {{ request('type') == '3' ? 'selected' : '' }}>Tutors</option>
                        <option value="4" {{ request('type') == '4' ? 'selected' : '' }}>Guardians</option>
                        <option value="5" {{ request('type') == '5' ? 'selected' : '' }}>Partners</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.profiles.index') }}" class="ml-2 px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Profiles List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($profiles->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($profiles as $profile)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($profile->tutor && $profile->tutor->photo)
                                                <img src="{{ asset('storage/' . $profile->tutor->photo) }}" 
                                                    alt="Photo" class="w-10 h-10 rounded-full object-cover mr-3">
                                            @elseif($profile->guardian && $profile->guardian->photo)
                                                <img src="{{ asset('storage/' . $profile->guardian->photo) }}" 
                                                    alt="Photo" class="w-10 h-10 rounded-full object-cover mr-3">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center mr-3">
                                                    <span class="text-gray-600 font-semibold">{{ substr($profile->first_name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $profile->full_name }}</div>
                                                <div class="text-sm text-gray-500">ID: {{ $profile->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($profile->type == 3)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Tutor
                                            </span>
                                        @elseif($profile->type == 4)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Guardian
                                            </span>
                                        @elseif($profile->type == 5)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                                Partner
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $profile->mobile }}</div>
                                        <div class="text-sm text-gray-500">{{ $profile->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $profile->profile_completed_at ? $profile->profile_completed_at->format('d M Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.profiles.show', $profile->id) }}" 
                                            class="text-blue-600 hover:text-blue-900 mr-3">
                                            Review
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $profiles->links() }}
                </div>
            @else
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No pending profiles</h3>
                    <p class="mt-1 text-sm text-gray-500">All profiles have been reviewed.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
