@extends('layouts.app')

@section('title', 'Browse Tutors')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Browse Tutors</h1>
            <p class="text-gray-600 mt-1">Find qualified tutors for your needs</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Filters Sidebar -->
            <aside class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                    <h3 class="font-bold text-gray-800 mb-4">Filters</h3>
                    <form method="GET" action="{{ route('guardian.tutors.index') }}">
                        <!-- Subject Filter -->
                        <div class="mb-6">
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <select name="subject" id="subject" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                                <option value="">All Subjects</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ request('subject') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Class Level Filter -->
                        <div class="mb-6">
                            <label for="class" class="block text-sm font-medium text-gray-700 mb-2">Class Level</label>
                            <select name="class" id="class" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                                <option value="">All Classes</option>
                                @foreach($classLevels as $class)
                                    <option value="{{ $class->id }}" {{ request('class') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Area Filter -->
                        <div class="mb-6">
                            <label for="area" class="block text-sm font-medium text-gray-700 mb-2">Area</label>
                            <select name="area" id="area" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                                <option value="">All Areas</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>
                                        {{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Gender Filter -->
                        <div class="mb-6">
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                            <select name="gender" id="gender" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                                <option value="">Any</option>
                                <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        <!-- Max Salary Filter -->
                        <div class="mb-6">
                            <label for="max_salary" class="block text-sm font-medium text-gray-700 mb-2">
                                Max Expected Salary
                            </label>
                            <input type="number" name="max_salary" id="max_salary" 
                                value="{{ request('max_salary') }}" step="500"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                placeholder="e.g., 5000">
                        </div>

                        <button type="submit" 
                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                            Apply Filters
                        </button>
                        <a href="{{ route('guardian.tutors.index') }}" 
                            class="block text-center w-full px-4 py-2 mt-2 text-gray-600 hover:text-gray-800 text-sm">
                            Reset
                        </a>
                    </form>
                </div>
            </aside>

            <!-- Tutors List -->
            <main class="flex-1">
                @if($tutors->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($tutors as $tutor)
                            <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow p-6">
                                <div class="flex items-start gap-4 mb-4">
                                    @if($tutor->photo)
                                        <img src="{{ asset('storage/' . $tutor->photo) }}" 
                                            alt="Photo" class="w-16 h-16 rounded-full object-cover">
                                    @else
                                        <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-blue-600 font-semibold text-xl">
                                                {{ substr($tutor->user->first_name, 0, 1) }}
                                            </span>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-gray-800">{{ $tutor->user->full_name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $tutor->gender }} • {{ $tutor->area->name }}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-yellow-500">★</span>
                                            <span class="text-sm text-gray-600">
                                                {{ number_format($tutor->average_rating ?? 0, 1) }} 
                                                ({{ $tutor->reviews_count ?? 0 }} reviews)
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                @if($tutor->bio)
                                    <p class="text-sm text-gray-700 mb-4 line-clamp-2">{{ $tutor->bio }}</p>
                                @endif

                                <!-- Subjects -->
                                <div class="mb-3">
                                    <p class="text-xs font-medium text-gray-500 mb-2">Subjects:</p>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($tutor->subjects as $index => $subjectId)
                                            @if($index < 3)
                                                @php
                                                    $subject = \App\Models\Subject::find($subjectId);
                                                @endphp
                                                @if($subject)
                                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs">
                                                        {{ $subject->name }}
                                                    </span>
                                                @endif
                                            @endif
                                        @endforeach
                                        @if(count($tutor->subjects) > 3)
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">
                                                +{{ count($tutor->subjects) - 3 }} more
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Salary Range -->
                                <div class="flex items-center justify-between py-3 border-t border-gray-200">
                                    <span class="text-sm text-gray-600">Expected Salary</span>
                                    <span class="font-semibold text-blue-600">
                                        ৳{{ number_format($tutor->expected_minimum_salary) }} - ৳{{ number_format($tutor->expected_maximum_salary) }}
                                    </span>
                                </div>

                                <a href="{{ route('guardian.tutors.show', $tutor->id) }}" 
                                    class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors mt-4">
                                    View Profile
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $tutors->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No tutors found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search filters.</p>
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>
@endsection
