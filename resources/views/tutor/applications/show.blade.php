@extends('layouts.app')

@section('title', 'Application Details')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Back Button -->
        <a href="{{ route('tutor.applications.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-2 mb-6">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Applications
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Application Header -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Application Details</h1>
                            <p class="text-gray-600 mt-1">{{ $application->post->post_code }}</p>
                        </div>
                        <div>
                            @if($application->status == 'Pending')
                                <span class="px-4 py-2 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending Review
                                </span>
                            @elseif($application->status == 'Shortlisted')
                                <span class="px-4 py-2 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Shortlisted
                                </span>
                            @elseif($application->status == 'Accepted')
                                <span class="px-4 py-2 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                    Accepted ✓
                                </span>
                            @else
                                <span class="px-4 py-2 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                    Rejected
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($application->status == 'Accepted')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <p class="text-green-800 font-medium">
                                🎉 Congratulations! Your application has been accepted. 
                                @if($tuition)
                                    Check your <a href="{{ route('tutor.tuitions.index') }}" class="underline font-bold">tuitions page</a> to confirm and start.
                                @endif
                            </p>
                        </div>
                    @elseif($application->status == 'Shortlisted')
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-blue-800 font-medium">
                                👍 You've been shortlisted! The guardian is reviewing your profile.
                            </p>
                        </div>
                    @elseif($application->status == 'Rejected')
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <p class="text-red-800 font-medium">
                                Unfortunately, your application was not selected this time.
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Your Application -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Your Application</h2>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Expected Salary</p>
                            <p class="text-2xl font-bold text-blue-600">৳{{ number_format($application->expected_salary) }}</p>
                            <p class="text-xs text-gray-500 mt-1">per month</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Applied On</p>
                            <p class="font-semibold text-gray-800">{{ $application->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    @if($application->cover_letter)
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-500 mb-2">Cover Letter</p>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-line">{{ $application->cover_letter }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Post Details -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Post Details</h2>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Class Level</p>
                            <p class="font-semibold text-gray-800">{{ $application->post->classLevel->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Curriculum</p>
                            <p class="font-semibold text-gray-800">{{ $application->post->curriculum }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tuition Type</p>
                            <p class="font-semibold text-gray-800">{{ $application->post->tuition_type }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Area</p>
                            <p class="font-semibold text-gray-800">{{ $application->post->area->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Days Per Week</p>
                            <p class="font-semibold text-gray-800">{{ $application->post->days_per_week }} days</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Duration</p>
                            <p class="font-semibold text-gray-800">{{ $application->post->duration_in_months }} months</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Offered Salary</p>
                            <p class="text-lg font-bold text-blue-600">৳{{ number_format($application->post->offered_salary) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Students</p>
                            <p class="font-semibold text-gray-800">{{ $application->post->number_of_students }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Subjects</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($application->post->preferred_subjects as $subjectId)
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

                    @if($application->post->requirements)
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 mb-2">Requirements</p>
                            <p class="text-gray-700 bg-gray-50 rounded p-3">{{ $application->post->requirements }}</p>
                        </div>
                    @endif
                </div>

                <!-- Guardian Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Guardian Information</h2>
                    <div class="flex items-center gap-4">
                        @if($application->post->guardian->photo)
                            <img src="{{ asset('storage/' . $application->post->guardian->photo) }}" 
                                alt="Photo" class="w-16 h-16 rounded-full object-cover">
                        @else
                            <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center">
                                <span class="text-green-600 font-semibold text-xl">
                                    {{ substr($application->post->guardian->user->first_name, 0, 1) }}
                                </span>
                            </div>
                        @endif
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800 text-lg">{{ $application->post->guardian->user->full_name }}</p>
                            <p class="text-sm text-gray-600">{{ $application->post->guardian->area->name }}</p>
                            @if($application->status == 'Accepted' || $application->status == 'Shortlisted')
                                <p class="text-sm text-gray-600 mt-1">{{ $application->post->guardian->user->mobile }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Timeline -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Application Timeline</h3>
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Applied</p>
                                <p class="text-sm text-gray-600">{{ $application->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>

                        @if($application->status != 'Pending')
                            <div class="flex gap-3">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-{{ $application->status == 'Rejected' ? 'red' : 'blue' }}-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-{{ $application->status == 'Rejected' ? 'red' : 'blue' }}-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $application->status }}</p>
                                    <p class="text-sm text-gray-600">{{ $application->updated_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($tuition)
                            <div class="flex gap-3">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Tuition Created</p>
                                    <p class="text-sm text-gray-600">{{ $tuition->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                @if($application->status == 'Pending' || $application->status == 'Shortlisted')
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="font-bold text-gray-800 mb-4">Actions</h3>
                        <form action="{{ route('tutor.applications.destroy', $application->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to withdraw this application?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                Withdraw Application
                            </button>
                        </form>
                    </div>
                @endif

                @if($tuition)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="font-bold text-gray-800 mb-4">Tuition</h3>
                        <a href="{{ route('tutor.tuitions.show', $tuition->id) }}" 
                            class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            View Tuition Details
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
