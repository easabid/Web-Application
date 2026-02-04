@extends('layouts.app')

@section('title', 'Tuition Post Details')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <a href="{{ route('tutor.posts.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 mb-6">
            <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Back to Posts
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                                Class {{ $post->classLevel->name }} Tuition
                            </h1>
                            <div class="flex items-center gap-4 text-gray-600">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $post->area->name }}, {{ $post->area->parent->name }}
                                </span>
                                <span>Post Code: {{ $post->post_code }}</span>
                            </div>
                        </div>
                        <span class="px-3 py-1 text-sm font-medium rounded bg-green-100 text-green-800">
                            {{ $post->tuition_type }}
                        </span>
                    </div>

                    <!-- Key Details -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6 p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Salary</p>
                            <p class="text-xl font-bold text-green-600">৳{{ number_format($post->offered_salary) }}</p>
                            <p class="text-xs text-gray-500">per month</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Students</p>
                            <p class="text-xl font-bold text-gray-900">{{ $post->number_of_students }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Days/Week</p>
                            <p class="text-xl font-bold text-gray-900">{{ $post->days_per_week }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Duration</p>
                            <p class="text-xl font-bold text-gray-900">{{ $post->duration }}</p>
                            <p class="text-xs text-gray-500">hours/day</p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-2">Requirements</h3>
                        <p class="text-gray-700 whitespace-pre-line">{{ $post->requirements }}</p>
                    </div>

                    <!-- Subjects -->
                    @if($post->preferred_subjects && count($post->preferred_subjects) > 0)
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-2">Subjects</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($post->preferred_subjects as $subjectId)
                                @php
                                    $subject = \App\Models\Subject::find($subjectId);
                                @endphp
                                @if($subject)
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-lg">{{ $subject->name_bn }}</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Additional Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm text-gray-500">Curriculum</p>
                            <p class="font-medium text-gray-900">{{ $post->curriculum }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Gender Preference</p>
                            <p class="font-medium text-gray-900">{{ $post->tutor_gender }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Student Gender</p>
                            <p class="font-medium text-gray-900">{{ $post->student_gender }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Preferred Medium</p>
                            <p class="font-medium text-gray-900">{{ $post->preferred_medium }}</p>
                        </div>
                    </div>

                    <!-- Posted Info -->
                    <div class="text-sm text-gray-500 border-t pt-4">
                        <p>Posted by {{ $post->guardian->user->first_name }} {{ substr($post->guardian->user->last_name, 0, 1) }}. on {{ $post->created_at->format('F j, Y') }}</p>
                        <p>{{ $post->view_count }} views • {{ $post->application_count }} applications • Expires {{ $post->expires_at->format('F j, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                    @if(!$matchesGender)
                    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-yellow-800">
                            ⚠️ This post prefers {{ $post->tutor_gender }} tutors. Your profile shows {{ auth()->user()->tutor->gender }}.
                        </p>
                    </div>
                    @endif

                    @if($hasApplied)
                    <div class="p-4 bg-green-50 border border-green-200 rounded-lg text-center">
                        <svg class="w-12 h-12 text-green-600 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <p class="font-semibold text-green-800">Already Applied</p>
                        <p class="text-sm text-green-700 mt-1">You have applied to this post</p>
                        <a href="{{ route('tutor.applications.index') }}" class="block mt-3 text-sm text-green-700 hover:text-green-800 underline">
                            View My Applications
                        </a>
                    </div>
                    @else
                    <h3 class="font-semibold text-gray-900 mb-4">Apply for This Tuition</h3>
                    
                    <form method="POST" action="{{ route('tutor.applications.store') }}">
                        @csrf
                        <input type="hidden" name="tuition_post_id" value="{{ $post->id }}">

                        <div class="mb-4">
                            <label for="expected_salary" class="block text-sm font-medium text-gray-700 mb-2">Your Expected Salary (৳/month)</label>
                            <input type="number" 
                                   id="expected_salary" 
                                   name="expected_salary" 
                                   value="{{ auth()->user()->tutor->expected_minimum_salary }}"
                                   min="1000"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-2">Cover Letter (Min 50 chars)</label>
                            <textarea id="cover_letter" 
                                      name="cover_letter" 
                                      rows="6"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                      placeholder="Explain why you are the best fit for this tuition..."
                                      required></textarea>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                            Submit Application
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
