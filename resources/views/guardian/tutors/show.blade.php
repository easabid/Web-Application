@extends('layouts.app')

@section('title', 'Tutor Profile')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Back Button -->
        <a href="{{ route('guardian.tutors.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-2 mb-6">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Tutors
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Profile Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-center">
                        @if($tutor->photo)
                            <img src="{{ asset('storage/' . $tutor->photo) }}" 
                                alt="Photo" class="w-32 h-32 rounded-full mx-auto object-cover mb-4">
                        @else
                            <div class="w-32 h-32 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-4">
                                <span class="text-blue-600 font-semibold text-4xl">
                                    {{ substr($tutor->user->first_name, 0, 1) }}
                                </span>
                            </div>
                        @endif
                        <h2 class="text-2xl font-bold text-gray-800">{{ $tutor->user->full_name }}</h2>
                        <p class="text-gray-600 mt-1">{{ $tutor->gender }} • {{ $tutor->area->name }}</p>
                        
                        @if($tutor->average_rating)
                            <div class="flex items-center justify-center gap-2 mt-3">
                                <div class="flex items-center gap-1">
                                    <span class="text-yellow-500 text-xl">★</span>
                                    <span class="text-2xl font-bold text-gray-800">{{ number_format($tutor->average_rating, 1) }}</span>
                                </div>
                                <span class="text-sm text-gray-600">({{ $tutor->reviews_count }} reviews)</span>
                            </div>
                        @endif

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="space-y-3 text-left">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm text-gray-600">{{ $tutor->user->email }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span class="text-sm text-gray-600">{{ $tutor->user->mobile }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm text-gray-600">Born {{ $tutor->date_of_birth->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Salary Range -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Expected Salary</h3>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-blue-600">
                            ৳{{ number_format($tutor->expected_minimum_salary) }}
                        </p>
                        <p class="text-gray-600 my-1">to</p>
                        <p class="text-3xl font-bold text-blue-600">
                            ৳{{ number_format($tutor->expected_maximum_salary) }}
                        </p>
                        <p class="text-sm text-gray-500 mt-2">per month</p>
                    </div>
                </div>

                <!-- Stats -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Statistics</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Total Tuitions</span>
                            <span class="font-semibold text-gray-800">{{ $tutor->tuitions_count ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Completed</span>
                            <span class="font-semibold text-green-600">{{ $tutor->completed_tuitions_count ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Success Rate</span>
                            <span class="font-semibold text-purple-600">
                                {{ $tutor->tuitions_count > 0 ? round(($tutor->completed_tuitions_count / $tutor->tuitions_count) * 100) : 0 }}%
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Member Since</span>
                            <span class="font-semibold text-gray-800">{{ $tutor->user->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- About -->
                @if($tutor->bio)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">About</h2>
                        <p class="text-gray-700 leading-relaxed">{{ $tutor->bio }}</p>
                    </div>
                @endif

                <!-- Teaching Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Teaching Information</h2>
                    
                    <!-- Subjects -->
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-500 mb-3">Subjects</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tutor->subjects as $subjectId)
                                @php
                                    $subject = \App\Models\Subject::find($subjectId);
                                @endphp
                                @if($subject)
                                    <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm font-medium">
                                        {{ $subject->name }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Classes -->
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-500 mb-3">Class Levels</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tutor->class_levels as $classId)
                                @php
                                    $class = \App\Models\ClassLevel::find($classId);
                                @endphp
                                @if($class)
                                    <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-sm font-medium">
                                        {{ $class->name }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Preferred Areas -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-3">Preferred Teaching Areas</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tutor->preferred_areas as $areaId)
                                @php
                                    $area = \App\Models\Area::find($areaId);
                                @endphp
                                @if($area)
                                    <span class="px-3 py-1 bg-purple-50 text-purple-700 rounded-full text-sm font-medium">
                                        {{ $area->name }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Qualifications -->
                @if($tutor->qualifications->count() > 0)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Educational Qualifications</h2>
                        <div class="space-y-4">
                            @foreach($tutor->qualifications as $qualification)
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <h3 class="font-semibold text-gray-800">{{ $qualification->degree }}</h3>
                                    <p class="text-gray-600 text-sm">{{ $qualification->institution }}</p>
                                    <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                                        <span>{{ $qualification->field_of_study }}</span>
                                        <span>•</span>
                                        <span>{{ $qualification->passing_year }}</span>
                                        <span>•</span>
                                        <span class="font-medium text-blue-600">{{ $qualification->result }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Reviews -->
                @if($tutor->reviews->count() > 0)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Reviews</h2>
                        <div class="space-y-4">
                            @foreach($tutor->reviews as $review)
                                <div class="border-b border-gray-200 pb-4 last:border-0">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $review->guardian->user->full_name }}</p>
                                            <div class="flex items-center gap-1 mt-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="text-{{ $i <= $review->rating ? 'yellow' : 'gray' }}-400">★</span>
                                                @endfor
                                            </div>
                                        </div>
                                        <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if($review->comment)
                                        <p class="text-gray-700 text-sm">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
