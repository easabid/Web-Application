@extends('layouts.app')

@section('title', 'Post Details')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('guardian.posts.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-2 mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Posts
            </a>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $post->post_code }}</h1>
                    @if($post->status == 'Active')
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 mt-2 inline-block">
                            Active
                        </span>
                    @elseif($post->status == 'Closed')
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 mt-2 inline-block">
                            Closed
                        </span>
                    @elseif($post->status == 'Expired')
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800 mt-2 inline-block">
                            Expired
                        </span>
                    @endif
                </div>
                @if($post->status == 'Active')
                    <a href="{{ route('guardian.posts.edit', $post->id) }}" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Edit Post
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Student Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Student Information</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Class Level</p>
                            <p class="font-semibold text-gray-800">{{ $post->classLevel->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Gender</p>
                            <p class="font-semibold text-gray-800">{{ $post->student_gender }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Number of Students</p>
                            <p class="font-semibold text-gray-800">{{ $post->number_of_students }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Curriculum</p>
                            <p class="font-semibold text-gray-800">{{ $post->curriculum }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Subjects</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($post->preferred_subjects as $subjectId)
                                @php
                                    $subject = \App\Models\Subject::find($subjectId);
                                @endphp
                                @if($subject)
                                    <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm">
                                        {{ $subject->name }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Tuition Details -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Tuition Details</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Tuition Type</p>
                            <p class="font-semibold text-gray-800">{{ $post->tuition_type }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Area</p>
                            <p class="font-semibold text-gray-800">{{ $post->area->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Days Per Week</p>
                            <p class="font-semibold text-gray-800">{{ $post->days_per_week }} days</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Duration</p>
                            <p class="font-semibold text-gray-800">{{ $post->duration_in_months }} months</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Offered Salary</p>
                            <p class="text-2xl font-bold text-blue-600">৳{{ number_format($post->offered_salary) }}/month</p>
                        </div>
                    </div>
                </div>

                <!-- Tutor Preferences -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Tutor Preferences</h2>
                    <div class="grid grid-cols-2 gap-4">
                        @if($post->preferred_tutor_gender)
                            <div>
                                <p class="text-sm text-gray-500">Preferred Gender</p>
                                <p class="font-semibold text-gray-800">{{ $post->preferred_tutor_gender }}</p>
                            </div>
                        @endif
                        @if($post->preferred_medium)
                            <div>
                                <p class="text-sm text-gray-500">Preferred Medium</p>
                                <p class="font-semibold text-gray-800">{{ $post->preferred_medium }}</p>
                            </div>
                        @endif
                    </div>
                    @if($post->requirements)
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 mb-2">Requirements</p>
                            <p class="text-gray-700 bg-gray-50 rounded p-3">{{ $post->requirements }}</p>
                        </div>
                    @endif
                </div>

                <!-- Applications -->
                @if($applications->count() > 0)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Applications ({{ $applications->count() }})</h2>
                        <div class="space-y-3">
                            @foreach($applications as $application)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center gap-3">
                                        @if($application->tutor->photo)
                                            <img src="{{ asset('storage/' . $application->tutor->photo) }}" 
                                                alt="Photo" class="w-12 h-12 rounded-full object-cover">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-blue-600 font-semibold">
                                                    {{ substr($application->tutor->user->first_name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $application->tutor->user->full_name }}</p>
                                            <p class="text-sm text-gray-600">৳{{ number_format($application->expected_salary) }} • {{ $application->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        @if($application->status == 'Pending')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($application->status == 'Shortlisted')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Shortlisted
                                            </span>
                                        @elseif($application->status == 'Accepted')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Accepted
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                Rejected
                                            </span>
                                        @endif
                                        <a href="{{ route('guardian.applications.show', $application->id) }}" 
                                            class="text-blue-600 hover:text-blue-700">
                                            View →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Stats Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Post Stats</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Views</span>
                            <span class="font-semibold text-gray-800">{{ $post->view_count }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Applications</span>
                            <span class="font-semibold text-blue-600">{{ $post->application_count }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Posted</span>
                            <span class="font-semibold text-gray-800">{{ $post->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Expires</span>
                            <span class="font-semibold text-{{ $post->expires_at->isPast() ? 'red' : 'gray' }}-600">
                                {{ $post->expires_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                @if($post->status == 'Active')
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="font-bold text-gray-800 mb-4">Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('guardian.posts.edit', $post->id) }}" 
                                class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Edit Post
                            </a>
                            <form action="{{ route('guardian.posts.destroy', $post->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this post?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="block w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    Delete Post
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
