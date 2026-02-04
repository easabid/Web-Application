@extends('layouts.app')

@section('title', 'Tuition Details')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Back Button -->
        <a href="{{ route('guardian.tuitions.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-2 mb-6">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to My Tuitions
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Header -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">{{ $tuition->post->post_code }}</h1>
                            @if($tuition->status == 'Active')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 mt-2 inline-block">
                                    Active
                                </span>
                            @elseif($tuition->status == 'Pending')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 mt-2 inline-block">
                                    Pending Confirmation
                                </span>
                            @elseif($tuition->status == 'Completed')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 mt-2 inline-block">
                                    Completed
                                </span>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Monthly Salary</p>
                            <p class="text-3xl font-bold text-blue-600">৳{{ number_format($tuition->monthly_salary) }}</p>
                        </div>
                    </div>

                    @if($tuition->status == 'Pending' && !$tuition->guardian_confirmed_at)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                            <p class="text-yellow-800 font-medium">
                                ⚠️ Please confirm that the tuition has started.
                            </p>
                        </div>
                    @endif

                    @if($tuition->admin_verified_at)
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <p class="text-green-800 font-medium">
                                ✓ This tuition has been verified by admin on {{ $tuition->admin_verified_at->format('d M Y') }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Confirmation Status -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Confirmation Status</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-{{ $tuition->tutor_confirmed_at ? 'green' : 'gray' }}-50 rounded-lg p-4 border-2 border-{{ $tuition->tutor_confirmed_at ? 'green' : 'gray' }}-200">
                            <div class="flex items-center gap-3">
                                @if($tuition->tutor_confirmed_at)
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                                <div>
                                    <p class="text-sm text-gray-500">Tutor Confirmation</p>
                                    <p class="font-bold text-{{ $tuition->tutor_confirmed_at ? 'green' : 'gray' }}-700">
                                        {{ $tuition->tutor_confirmed_at ? 'Confirmed' : 'Waiting' }}
                                    </p>
                                    @if($tuition->tutor_confirmed_at)
                                        <p class="text-xs text-gray-600">{{ $tuition->tutor_confirmed_at->format('d M Y') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bg-{{ $tuition->guardian_confirmed_at ? 'green' : 'yellow' }}-50 rounded-lg p-4 border-2 border-{{ $tuition->guardian_confirmed_at ? 'green' : 'yellow' }}-200">
                            <div class="flex items-center gap-3">
                                @if($tuition->guardian_confirmed_at)
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                                <div>
                                    <p class="text-sm text-gray-500">Your Confirmation</p>
                                    <p class="font-bold text-{{ $tuition->guardian_confirmed_at ? 'green' : 'yellow' }}-700">
                                        {{ $tuition->guardian_confirmed_at ? 'Confirmed' : 'Action Required' }}
                                    </p>
                                    @if($tuition->guardian_confirmed_at)
                                        <p class="text-xs text-gray-600">{{ $tuition->guardian_confirmed_at->format('d M Y') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tutor Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Tutor Details</h2>
                    <div class="flex items-start gap-4 mb-6 pb-6 border-b border-gray-200">
                        @if($tuition->tutor->photo)
                            <img src="{{ asset('storage/' . $tuition->tutor->photo) }}" 
                                alt="Photo" class="w-20 h-20 rounded-full object-cover">
                        @else
                            <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-semibold text-2xl">
                                    {{ substr($tuition->tutor->user->first_name, 0, 1) }}
                                </span>
                            </div>
                        @endif
                        <div class="flex-1">
                            <p class="font-bold text-gray-800 text-lg">{{ $tuition->tutor->user->full_name }}</p>
                            <p class="text-sm text-gray-600">{{ $tuition->tutor->user->mobile }}</p>
                            <p class="text-sm text-gray-600">{{ $tuition->tutor->area->name }}</p>
                            @if($tuition->tutor->average_rating)
                                <div class="flex items-center gap-1 mt-2">
                                    <span class="text-yellow-500">★</span>
                                    <span class="font-semibold text-gray-800">{{ number_format($tuition->tutor->average_rating, 1) }}</span>
                                    <span class="text-sm text-gray-600">({{ $tuition->tutor->reviews_count }} reviews)</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Gender</p>
                            <p class="font-semibold text-gray-800">{{ $tuition->tutor->gender }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Area</p>
                            <p class="font-semibold text-gray-800">{{ $tuition->tutor->area->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tuition Details -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Tuition Information</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Class Level</p>
                            <p class="font-semibold text-gray-800">{{ $tuition->post->classLevel->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tuition Type</p>
                            <p class="font-semibold text-gray-800">{{ $tuition->post->tuition_type }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Days Per Week</p>
                            <p class="font-semibold text-gray-800">{{ $tuition->post->days_per_week }} days</p>
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
                        <p class="text-sm text-gray-500 mb-2">Subjects</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tuition->post->preferred_subjects as $subjectId)
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

                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-1">Student Address</p>
                        <p class="text-gray-700">{{ $tuition->student_address }}</p>
                    </div>
                </div>

                <!-- Review (if completed and not reviewed) -->
                @if($tuition->status == 'Completed' && !$tuition->is_reviewed_by_guardian)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                        <h3 class="font-bold text-yellow-800 mb-2">Review Pending</h3>
                        <p class="text-sm text-yellow-700 mb-4">Please write a review for this tutor to help other guardians.</p>
                        <a href="{{ route('guardian.tuitions.review', $tuition->id) }}" 
                            class="inline-block px-6 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                            Write Review
                        </a>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Actions -->
                @if($tuition->status == 'Pending' && !$tuition->guardian_confirmed_at)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="font-bold text-gray-800 mb-4">Action Required</h3>
                        <form action="{{ route('guardian.tuitions.confirm', $tuition->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                                Confirm Tuition Start
                            </button>
                        </form>
                        <p class="text-xs text-gray-500 mt-2 text-center">
                            Confirm that tuition has started
                        </p>
                    </div>
                @endif

                @if($tuition->status == 'Active' && !$tuition->end_date)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="font-bold text-gray-800 mb-4">Complete Tuition</h3>
                        <a href="{{ route('guardian.tuitions.complete', $tuition->id) }}" 
                            class="block w-full text-center px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium">
                            Mark as Completed
                        </a>
                        <p class="text-xs text-gray-500 mt-2 text-center">
                            Mark when tuition is finished
                        </p>
                    </div>
                @endif

                <!-- Timeline -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Timeline</h3>
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Tuition Created</p>
                                <p class="text-sm text-gray-600">{{ $tuition->created_at->format('d M Y') }}</p>
                            </div>
                        </div>

                        @if($tuition->tutor_confirmed_at)
                            <div class="flex gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Tutor Confirmed</p>
                                    <p class="text-sm text-gray-600">{{ $tuition->tutor_confirmed_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($tuition->guardian_confirmed_at)
                            <div class="flex gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">You Confirmed</p>
                                    <p class="text-sm text-gray-600">{{ $tuition->guardian_confirmed_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($tuition->admin_verified_at)
                            <div class="flex gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Admin Verified</p>
                                    <p class="text-sm text-gray-600">{{ $tuition->admin_verified_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($tuition->end_date)
                            <div class="flex gap-3">
                                <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Completed</p>
                                    <p class="text-sm text-gray-600">{{ $tuition->end_date->format('d M Y') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow p-6 text-white">
                    <h3 class="font-bold mb-2">Monthly Payment</h3>
                    <p class="text-3xl font-bold">৳{{ number_format($tuition->monthly_salary) }}</p>
                    @if($tuition->end_date && $tuition->start_date)
                        @php
                            $months = $tuition->start_date->diffInMonths($tuition->end_date);
                            $totalPaid = $months * $tuition->monthly_salary;
                        @endphp
                        <div class="mt-4 pt-4 border-t border-blue-400">
                            <p class="text-sm opacity-90">Total Paid</p>
                            <p class="text-2xl font-bold">৳{{ number_format($totalPaid) }}</p>
                            <p class="text-xs opacity-75 mt-1">{{ $months }} months</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
