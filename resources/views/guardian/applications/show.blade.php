@extends('layouts.app')

@section('title', 'Application Details')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Back Button -->
        <a href="{{ route('guardian.applications.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-2 mb-6">
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
                            <h1 class="text-3xl font-bold text-gray-800">Application for {{ $application->post->post_code }}</h1>
                            <p class="text-gray-600 mt-1">Review tutor's application</p>
                        </div>
                        <div>
                            @if($application->status == 'Pending')
                                <span class="px-4 py-2 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
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
                </div>

                <!-- Tutor Profile -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Tutor Profile</h2>
                    <div class="flex items-start gap-4 mb-6">
                        @if($application->tutor->photo)
                            <img src="{{ asset('storage/' . $application->tutor->photo) }}" 
                                alt="Photo" class="w-24 h-24 rounded-full object-cover">
                        @else
                            <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-semibold text-3xl">
                                    {{ substr($application->tutor->user->first_name, 0, 1) }}
                                </span>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-800">{{ $application->tutor->user->full_name }}</h3>
                            <p class="text-gray-600">{{ $application->tutor->gender }} • {{ $application->tutor->area->name }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                @if($application->tutor->average_rating)
                                    <span class="text-yellow-500">★</span>
                                    <span class="font-semibold text-gray-800">{{ number_format($application->tutor->average_rating, 1) }}</span>
                                    <span class="text-sm text-gray-600">({{ $application->tutor->reviews_count }} reviews)</span>
                                @else
                                    <span class="text-sm text-gray-500">No reviews yet</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-4 mt-3 text-sm text-gray-600">
                                <span>📧 {{ $application->tutor->user->email }}</span>
                                <span>📱 {{ $application->tutor->user->mobile }}</span>
                            </div>
                        </div>
                    </div>

                    @if($application->tutor->bio)
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-500 mb-2">About</p>
                            <p class="text-gray-700">{{ $application->tutor->bio }}</p>
                        </div>
                    @endif

                    <!-- Teaching Info -->
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Subjects</p>
                            <p class="font-semibold text-gray-800">{{ count($application->tutor->subjects) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Classes</p>
                            <p class="font-semibold text-gray-800">{{ count($application->tutor->class_levels) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Experience</p>
                            <p class="font-semibold text-gray-800">{{ $application->tutor->completed_tuitions_count ?? 0 }} tuitions</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-gray-500 mb-2">Subjects</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($application->tutor->subjects as $subjectId)
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

                    <div class="mb-4">
                        <p class="text-sm text-gray-500 mb-2">Expected Salary Range</p>
                        <p class="text-lg font-bold text-blue-600">
                            ৳{{ number_format($application->tutor->expected_minimum_salary) }} - ৳{{ number_format($application->tutor->expected_maximum_salary) }}
                        </p>
                    </div>
                </div>

                <!-- Application Details -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Application Details</h2>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Expected Salary</p>
                            <p class="text-2xl font-bold text-blue-600">৳{{ number_format($application->expected_salary) }}</p>
                            <p class="text-xs text-gray-500 mt-1">per month</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Applied On</p>
                            <p class="font-semibold text-gray-800">{{ $application->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $application->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    @if($application->cover_letter)
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-2">Cover Letter</p>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-line">{{ $application->cover_letter }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Qualifications -->
                @if($application->tutor->qualifications->count() > 0)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Educational Qualifications</h2>
                        <div class="space-y-4">
                            @foreach($application->tutor->qualifications as $qualification)
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <h3 class="font-semibold text-gray-800">{{ $qualification->degree }}</h3>
                                    <p class="text-gray-600">{{ $qualification->institution }}</p>
                                    <div class="flex items-center gap-4 mt-1 text-sm text-gray-500">
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
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Actions -->
                @if($application->status == 'Pending')
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="font-bold text-gray-800 mb-4">Actions</h3>
                        <div class="space-y-3">
                            <form action="{{ route('guardian.applications.shortlist', $application->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                    class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Shortlist
                                </button>
                            </form>
                            <form action="{{ route('guardian.applications.accept', $application->id) }}" method="POST"
                                onsubmit="return confirm('Accept this application? This will create a tuition.')">
                                @csrf
                                <button type="submit" 
                                    class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    Accept Application
                                </button>
                            </form>
                            <form action="{{ route('guardian.applications.reject', $application->id) }}" method="POST"
                                onsubmit="return confirm('Reject this application?')">
                                @csrf
                                <button type="submit" 
                                    class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                @elseif($application->status == 'Shortlisted')
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="font-bold text-gray-800 mb-4">Actions</h3>
                        <div class="space-y-3">
                            <form action="{{ route('guardian.applications.accept', $application->id) }}" method="POST"
                                onsubmit="return confirm('Accept this application? This will create a tuition.')">
                                @csrf
                                <button type="submit" 
                                    class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    Accept Application
                                </button>
                            </form>
                            <form action="{{ route('guardian.applications.reject', $application->id) }}" method="POST"
                                onsubmit="return confirm('Reject this application?')">
                                @csrf
                                <button type="submit" 
                                    class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                @elseif($application->status == 'Accepted')
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <h3 class="font-bold text-green-800 mb-2">✓ Application Accepted</h3>
                        <p class="text-sm text-green-700 mb-4">A tuition has been created for this application.</p>
                        @if($tuition)
                            <a href="{{ route('guardian.tuitions.show', $tuition->id) }}" 
                                class="block w-full text-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                View Tuition
                            </a>
                        @endif
                    </div>
                @endif

                <!-- Post Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Post Details</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Post Code</p>
                            <p class="font-semibold text-gray-800">{{ $application->post->post_code }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Class</p>
                            <p class="font-semibold text-gray-800">{{ $application->post->classLevel->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Offered Salary</p>
                            <p class="text-xl font-bold text-blue-600">৳{{ number_format($application->post->offered_salary) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            @if($application->post->status == 'Active')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ $application->post->status }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('guardian.posts.show', $application->post->id) }}" 
                        class="block w-full text-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors mt-4">
                        View Post
                    </a>
                </div>

                <!-- Comparison -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="font-bold text-blue-800 mb-4">Salary Comparison</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-blue-700">You're Offering</p>
                            <p class="text-2xl font-bold text-blue-900">৳{{ number_format($application->post->offered_salary) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-blue-700">Tutor Expects</p>
                            <p class="text-2xl font-bold text-blue-900">৳{{ number_format($application->expected_salary) }}</p>
                        </div>
                        @php
                            $difference = $application->expected_salary - $application->post->offered_salary;
                        @endphp
                        <div class="pt-3 border-t border-blue-300">
                            <p class="text-sm text-blue-700">Difference</p>
                            <p class="text-lg font-bold {{ $difference > 0 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $difference > 0 ? '+' : '' }}৳{{ number_format(abs($difference)) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
