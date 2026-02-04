@extends('layouts.app')

@section('title', 'Browse Tuition Posts')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl font-bold text-gray-900">Available Tuition Opportunities</h1>
            <p class="text-gray-600 mt-1">Find and apply to tuition posts that match your expertise</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Filters Sidebar -->
            <div class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                    <h3 class="font-semibold text-gray-900 mb-4">Filters</h3>
                    
                    <form method="GET" action="{{ route('tutor.posts.index') }}">
                        <!-- Subject -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <select name="subject_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <option value="">All Subjects</option>
                                @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name_bn }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Class Level -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Class</label>
                            <select name="class_level_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <option value="">All Classes</option>
                                @foreach($classLevels as $level)
                                <option value="{{ $level->id }}" {{ request('class_level_id') == $level->id ? 'selected' : '' }}>
                                    {{ $level->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Area -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Area</label>
                            <select name="area_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <option value="">All Areas</option>
                                @foreach($areas as $area)
                                <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>
                                    {{ $area->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Salary Range -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Min Salary (৳)</label>
                            <input type="number" name="min_salary" value="{{ request('min_salary') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" placeholder="5000">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Max Salary (৳)</label>
                            <input type="number" name="max_salary" value="{{ request('max_salary') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" placeholder="15000">
                        </div>

                        <!-- Sort -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                            <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest First</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                <option value="salary_high" {{ request('sort') == 'salary_high' ? 'selected' : '' }}>Salary High to Low</option>
                                <option value="salary_low" {{ request('sort') == 'salary_low' ? 'selected' : '' }}>Salary Low to High</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
                            Apply Filters
                        </button>
                        
                        @if(request()->hasAny(['subject_id', 'class_level_id', 'area_id', 'min_salary', 'max_salary', 'sort']))
                        <a href="{{ route('tutor.posts.index') }}" class="block w-full text-center mt-2 text-sm text-gray-600 hover:text-gray-800">
                            Clear Filters
                        </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Posts List -->
            <div class="flex-1">
                @if($posts->isEmpty())
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Posts Found</h3>
                    <p class="text-gray-600">Try adjusting your filters or check back later.</p>
                </div>
                @else
                <div class="space-y-4">
                    @foreach($posts as $post)
                    <div class="bg-white rounded-lg shadow hover:shadow-md transition p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-xl font-semibold text-gray-900">
                                        Class {{ $post->classLevel->name }}
                                    </h3>
                                    <span class="px-2 py-1 text-xs font-medium rounded bg-green-100 text-green-800">
                                        {{ $post->tuition_type }}
                                    </span>
                                </div>
                                <p class="text-gray-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $post->area->name }}, {{ $post->area->parent->name }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-green-600">৳{{ number_format($post->offered_salary) }}</p>
                                <p class="text-sm text-gray-500">per month</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div>
                                <p class="text-xs text-gray-500">Students</p>
                                <p class="font-medium text-gray-900">{{ $post->number_of_students }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Days/Week</p>
                                <p class="font-medium text-gray-900">{{ $post->days_per_week }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Gender Preference</p>
                                <p class="font-medium text-gray-900">{{ $post->tutor_gender }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Curriculum</p>
                                <p class="font-medium text-gray-900">{{ $post->curriculum }}</p>
                            </div>
                        </div>

                        @if($post->preferred_subjects && count($post->preferred_subjects) > 0)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-1">Subjects:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($post->preferred_subjects as $subjectId)
                                    @php
                                        $subject = $subjects->find($subjectId);
                                    @endphp
                                    @if($subject)
                                    <span class="px-2 py-1 text-xs bg-indigo-50 text-indigo-700 rounded">{{ $subject->name_bn }}</span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                            <div class="text-sm text-gray-500">
                                <span>Posted {{ $post->created_at->diffForHumans() }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $post->application_count }} applications</span>
                            </div>
                            <a href="{{ route('tutor.posts.show', $post->id) }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                                View Details
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
