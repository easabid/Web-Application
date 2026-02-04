@extends('layouts.app')

@section('title', 'Verify Tuition')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Back Button -->
        <a href="{{ route('admin.tuitions.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-2 mb-6">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Tuitions
        </a>

        <!-- Alert Messages -->
        @if(!$tuition->tutor_confirmed_at || !$tuition->guardian_confirmed_at)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Incomplete Confirmations</h3>
                        <p class="mt-1 text-sm text-yellow-700">
                            Both tutor and guardian must confirm the tuition before you can verify it.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if($tuition->admin_verified_at)
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Tuition Verified ✓</h3>
                        <p class="mt-1 text-sm text-green-700">
                            This tuition has been verified on {{ $tuition->admin_verified_at->format('d M Y, h:i A') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if($tuition->admin_rejected_at)
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Tuition Rejected</h3>
                        <p class="mt-1 text-sm text-red-700">{{ $tuition->admin_rejection_reason ?? 'No reason provided' }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Tuition Header -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h1 class="text-3xl font-bold text-gray-800">{{ $tuition->post->post_code }}</h1>
                        @if($tuition->status == 'Pending')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        @elseif($tuition->status == 'Active')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        @elseif($tuition->status == 'Completed')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                Completed
                            </span>
                        @elseif($tuition->status == 'Cancelled')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Cancelled
                            </span>
                        @endif
                    </div>
                    <div class="text-3xl font-bold text-blue-600">৳{{ number_format($tuition->monthly_salary) }}/month</div>
                </div>

                <!-- Confirmation Status -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Confirmation Status</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Tutor Confirmation -->
                        <div class="p-4 rounded-lg {{ $tuition->tutor_confirmed_at ? 'bg-green-50' : 'bg-gray-50' }}">
                            <div class="flex items-center gap-2 mb-2">
                                @if($tuition->tutor_confirmed_at)
                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                                <h3 class="font-bold {{ $tuition->tutor_confirmed_at ? 'text-green-800' : 'text-gray-600' }}">
                                    Tutor Confirmation
                                </h3>
                            </div>
                            <p class="text-sm {{ $tuition->tutor_confirmed_at ? 'text-green-700' : 'text-gray-500' }}">
                                @if($tuition->tutor_confirmed_at)
                                    Confirmed on {{ $tuition->tutor_confirmed_at->format('d M Y') }}
                                @else
                                    Not confirmed yet
                                @endif
                            </p>
                        </div>

                        <!-- Guardian Confirmation -->
                        <div class="p-4 rounded-lg {{ $tuition->guardian_confirmed_at ? 'bg-green-50' : 'bg-gray-50' }}">
                            <div class="flex items-center gap-2 mb-2">
                                @if($tuition->guardian_confirmed_at)
                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                                <h3 class="font-bold {{ $tuition->guardian_confirmed_at ? 'text-green-800' : 'text-gray-600' }}">
                                    Guardian Confirmation
                                </h3>
                            </div>
                            <p class="text-sm {{ $tuition->guardian_confirmed_at ? 'text-green-700' : 'text-gray-500' }}">
                                @if($tuition->guardian_confirmed_at)
                                    Confirmed on {{ $tuition->guardian_confirmed_at->format('d M Y') }}
                                @else
                                    Not confirmed yet
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tutor Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Tutor Information</h2>
                    <div class="flex items-start gap-4 mb-4">
                        @if($tuition->tutor->tutor && $tuition->tutor->tutor->photo)
                            <img src="{{ asset('storage/' . $tuition->tutor->tutor->photo) }}" 
                                alt="Photo" class="w-16 h-16 rounded-full object-cover">
                        @else
                            <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-semibold text-xl">
                                    {{ substr($tuition->tutor->first_name, 0, 1) }}
                                </span>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $tuition->tutor->full_name }}</h3>
                            <p class="text-gray-600">📧 {{ $tuition->tutor->email }}</p>
                            <p class="text-gray-600">📱 {{ $tuition->tutor->mobile }}</p>
                            @if($tuition->tutor->tutor)
                                <p class="text-gray-600">📍 {{ $tuition->tutor->tutor->area->name ?? 'N/A' }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Guardian Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Guardian Information</h2>
                    <div class="flex items-start gap-4 mb-4">
                        @if($tuition->guardian->guardian && $tuition->guardian->guardian->photo)
                            <img src="{{ asset('storage/' . $tuition->guardian->guardian->photo) }}" 
                                alt="Photo" class="w-16 h-16 rounded-full object-cover">
                        @else
                            <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center">
                                <span class="text-green-600 font-semibold text-xl">
                                    {{ substr($tuition->guardian->first_name, 0, 1) }}
                                </span>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $tuition->guardian->full_name }}</h3>
                            <p class="text-gray-600">📧 {{ $tuition->guardian->email }}</p>
                            <p class="text-gray-600">📱 {{ $tuition->guardian->mobile }}</p>
                            @if($tuition->guardian->guardian)
                                <p class="text-gray-600">📍 {{ $tuition->guardian->guardian->area->name ?? 'N/A' }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Student & Tuition Details -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Student & Tuition Details</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Student Name</p>
                            <p class="font-semibold text-gray-800">{{ $tuition->post->student_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Class</p>
                            <p class="font-semibold text-gray-800">{{ $tuition->post->classLevel->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Student Gender</p>
                            <p class="font-semibold text-gray-800">{{ $tuition->post->student_gender }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Number of Students</p>
                            <p class="font-semibold text-gray-800">{{ $tuition->post->number_of_students }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Curriculum</p>
                            <p class="font-semibold text-gray-800">{{ $tuition->post->curriculum }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tuition Type</p>
                            <p class="font-semibold text-gray-800">{{ $tuition->post->tuition_type }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Area</p>
                            <p class="font-semibold text-gray-800">{{ $tuition->post->area->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Days per Week</p>
                            <p class="font-semibold text-gray-800">{{ $tuition->post->days_per_week }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Duration</p>
                            <p class="font-semibold text-gray-800">{{ $tuition->post->duration_in_months }} months</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Start Date</p>
                            <p class="font-semibold text-gray-800">{{ $tuition->start_date->format('d M Y') }}</p>
                        </div>
                        @if($tuition->end_date)
                            <div>
                                <p class="text-sm text-gray-500">End Date</p>
                                <p class="font-semibold text-gray-800">{{ $tuition->end_date->format('d M Y') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Subjects ({{ count($tuition->post->preferred_subjects) }})</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tuition->post->preferred_subjects as $subjectId)
                                @php $subject = \App\Models\Subject::find($subjectId); @endphp
                                @if($subject)
                                    <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm">
                                        {{ $subject->name }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Admin Actions -->
                @if(!$tuition->admin_verified_at && !$tuition->admin_rejected_at)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Verification Actions</h2>
                        
                        @if($tuition->tutor_confirmed_at && $tuition->guardian_confirmed_at)
                            <div class="flex gap-4">
                                <!-- Verify Form -->
                                <form action="{{ route('admin.tuitions.verify', $tuition->id) }}" method="POST" class="flex-1"
                                    onsubmit="return confirm('Verify this tuition?')">
                                    @csrf
                                    <button type="submit" 
                                        class="w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold">
                                        ✓ Verify Tuition
                                    </button>
                                </form>

                                <!-- Reject Form -->
                                <button onclick="document.getElementById('rejectForm').classList.toggle('hidden')"
                                    class="flex-1 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold">
                                    ✗ Reject Tuition
                                </button>
                            </div>

                            <!-- Reject Form (Hidden by default) -->
                            <form id="rejectForm" action="{{ route('admin.tuitions.reject', $tuition->id) }}" 
                                method="POST" class="mt-4 hidden">
                                @csrf
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Rejection Reason *
                                </label>
                                <textarea name="rejection_reason" rows="3" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                    placeholder="Explain why this tuition is being rejected..."></textarea>
                                @error('rejection_reason')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <div class="flex gap-2 mt-3">
                                    <button type="submit" 
                                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                                        onclick="return confirm('Reject this tuition? Guardian and tutor will be notified.')">
                                        Submit Rejection
                                    </button>
                                    <button type="button" onclick="document.getElementById('rejectForm').classList.add('hidden')"
                                        class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <p class="text-yellow-800">
                                    ⚠️ Cannot verify until both tutor and guardian confirm the tuition start.
                                </p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Timeline -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Verification Timeline</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Tuition Created</p>
                                <p class="text-xs text-gray-600">{{ $tuition->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full {{ $tuition->tutor_confirmed_at ? 'bg-green-100' : 'bg-gray-100' }} flex items-center justify-center">
                                @if($tuition->tutor_confirmed_at)
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold {{ $tuition->tutor_confirmed_at ? 'text-gray-800' : 'text-gray-500' }}">
                                    Tutor Confirmed
                                </p>
                                @if($tuition->tutor_confirmed_at)
                                    <p class="text-xs text-gray-600">{{ $tuition->tutor_confirmed_at->format('d M Y, h:i A') }}</p>
                                @else
                                    <p class="text-xs text-gray-500">Waiting...</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full {{ $tuition->guardian_confirmed_at ? 'bg-green-100' : 'bg-gray-100' }} flex items-center justify-center">
                                @if($tuition->guardian_confirmed_at)
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold {{ $tuition->guardian_confirmed_at ? 'text-gray-800' : 'text-gray-500' }}">
                                    Guardian Confirmed
                                </p>
                                @if($tuition->guardian_confirmed_at)
                                    <p class="text-xs text-gray-600">{{ $tuition->guardian_confirmed_at->format('d M Y, h:i A') }}</p>
                                @else
                                    <p class="text-xs text-gray-500">Waiting...</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full {{ $tuition->admin_verified_at ? 'bg-green-100' : 'bg-gray-100' }} flex items-center justify-center">
                                @if($tuition->admin_verified_at)
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold {{ $tuition->admin_verified_at ? 'text-gray-800' : 'text-gray-500' }}">
                                    Admin Verified
                                </p>
                                @if($tuition->admin_verified_at)
                                    <p class="text-xs text-gray-600">{{ $tuition->admin_verified_at->format('d M Y, h:i A') }}</p>
                                @else
                                    <p class="text-xs text-gray-500">Pending...</p>
                                @endif
                            </div>
                        </div>

                        @if($tuition->status == 'Completed')
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Completed</p>
                                    <p class="text-xs text-gray-600">{{ $tuition->end_date ? $tuition->end_date->format('d M Y, h:i A') : 'N/A' }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow p-6">
                    <h3 class="font-bold mb-4">Payment Information</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm opacity-90">Monthly Salary</p>
                            <p class="text-2xl font-bold">৳{{ number_format($tuition->monthly_salary) }}</p>
                        </div>
                        @if($tuition->start_date && $tuition->end_date)
                            <div>
                                <p class="text-sm opacity-90">Total Paid</p>
                                @php
                                    $months = $tuition->start_date->diffInMonths($tuition->end_date);
                                    $total = $months * $tuition->monthly_salary;
                                @endphp
                                <p class="text-2xl font-bold">৳{{ number_format($total) }}</p>
                                <p class="text-xs opacity-75">({{ $months }} months)</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
