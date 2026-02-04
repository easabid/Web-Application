@extends('layouts.app')

@section('title', 'Post Details')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Back Button -->
        <a href="{{ route('partner.posts.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-2 mb-6">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to My Posts
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Header -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-start justify-between mb-4">
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
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Offered Salary</p>
                            <p class="text-3xl font-bold text-blue-600">৳{{ number_format($post->offered_salary) }}</p>
                            <p class="text-sm text-purple-600 font-semibold mt-1">
                                🔒 Commission: ৳{{ number_format($post->commission_amount) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Guardian Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Guardian Information</h2>
                    <div class="flex items-center gap-4">
                        @if($post->guardian->photo)
                            <img src="{{ asset('storage/' . $post->guardian->photo) }}" 
                                alt="Photo" class="w-16 h-16 rounded-full object-cover">
                        @else
                            <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center">
                                <span class="text-green-600 font-semibold text-xl">
                                    {{ substr($post->guardian->user->first_name, 0, 1) }}
                                </span>
                            </div>
                        @endif
                        <div>
                            <p class="font-semibold text-gray-800 text-lg">{{ $post->guardian->user->full_name }}</p>
                            <p class="text-sm text-gray-600">{{ $post->guardian->area->name }}</p>
                            <p class="text-sm text-gray-600">{{ $post->guardian->user->mobile }}</p>
                        </div>
                    </div>
                </div>

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
                                    <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm font-medium">
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
                    </div>
                </div>

                <!-- Tutor Preferences -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Tutor Preferences</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Preferred Gender</p>
                            <p class="font-semibold text-gray-800">{{ $post->preferred_tutor_gender ?: 'No Preference' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Preferred Medium</p>
                            <p class="font-semibold text-gray-800">{{ $post->preferred_medium ?: 'No Preference' }}</p>
                        </div>
                    </div>
                    @if($post->requirements)
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 mb-2">Requirements</p>
                            <p class="text-gray-700 bg-gray-50 rounded p-3">{{ $post->requirements }}</p>
                        </div>
                    @endif
                </div>

                <!-- Tuition Status (if exists) -->
                @if($tuition)
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold mb-4">Tuition Confirmed! 🎉</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm opacity-90">Tutor</p>
                                <p class="font-semibold">{{ $tuition->tutor->user->full_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm opacity-90">Monthly Salary</p>
                                <p class="font-semibold text-lg">৳{{ number_format($tuition->monthly_salary) }}</p>
                            </div>
                            <div>
                                <p class="text-sm opacity-90">Start Date</p>
                                <p class="font-semibold">{{ $tuition->start_date->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm opacity-90">Status</p>
                                <p class="font-semibold">{{ $tuition->status }}</p>
                            </div>
                        </div>
                        <a href="{{ route('partner.earnings.show', $tuition->id) }}" 
                            class="inline-block mt-4 px-6 py-2 bg-white text-purple-600 rounded-lg hover:bg-purple-50 transition-colors font-medium">
                            View Commission Details
                        </a>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Commission Info -->
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white rounded-lg shadow p-6">
                    <h3 class="font-bold mb-2 flex items-center gap-2">
                        🔒 Your Commission
                    </h3>
                    <p class="text-3xl font-bold">৳{{ number_format($post->commission_amount) }}</p>
                    <p class="text-sm opacity-90 mt-2">When tuition is confirmed and verified</p>
                    @if($tuition)
                        <div class="mt-4 pt-4 border-t border-yellow-400">
                            <p class="text-sm opacity-90">Commission Status</p>
                            @if($tuition->has_commission)
                                @if($tuition->commission && $tuition->commission->commission_status == 'Approved')
                                    <p class="font-bold text-lg">✓ Approved</p>
                                @elseif($tuition->commission && $tuition->commission->commission_status == 'Paid')
                                    <p class="font-bold text-lg">✓ Paid</p>
                                @else
                                    <p class="font-bold text-lg">⏳ Pending Approval</p>
                                @endif
                            @else
                                <p class="font-bold text-lg">⏳ Waiting Verification</p>
                            @endif
                        </div>
                    @endif
                </div>

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
                            <a href="{{ route('partner.posts.edit', $post->id) }}" 
                                class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Edit Post
                            </a>
                            <form action="{{ route('partner.posts.destroy', $post->id) }}" method="POST"
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

                <!-- Referral Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="font-bold text-blue-800 mb-2">Referral Link</h3>
                    <p class="text-sm text-blue-700 mb-3">Share this post to get more applications</p>
                    <div class="flex gap-2">
                        <input type="text" readonly 
                            value="{{ route('tutor.posts.show', ['post' => $post->id, 'ref' => auth()->user()->referral_code]) }}"
                            class="flex-1 px-3 py-2 border border-blue-300 rounded text-xs bg-white"
                            id="referral-link">
                        <button onclick="copyReferralLink()" 
                            class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors text-sm">
                            Copy
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyReferralLink() {
        const linkInput = document.getElementById('referral-link');
        linkInput.select();
        document.execCommand('copy');
        alert('Link copied to clipboard!');
    }
</script>
@endsection
