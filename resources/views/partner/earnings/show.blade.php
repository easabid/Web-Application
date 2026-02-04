@extends('layouts.app')

@section('title', 'Commission Details')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Back Button -->
        <a href="{{ route('partner.earnings.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-2 mb-6">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Earnings
        </a>

        <!-- Status Alert -->
        @if($tuition->commission_status == 'Waiting Verification')
            <div class="bg-gray-50 border-l-4 border-gray-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-800">Waiting for Admin Verification</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            This tuition needs to be verified by admin before commission can be processed.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if($tuition->commission_status == 'Pending Approval')
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Commission Pending Approval</h3>
                        <p class="mt-1 text-sm text-yellow-700">
                            Your commission is waiting for admin approval.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if($tuition->commission_status == 'Approved')
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Commission Approved ✓</h3>
                        <p class="mt-1 text-sm text-green-700">
                            Your commission has been approved! You can request a payout now.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if($tuition->commission_status == 'Paid')
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Commission Paid ✓</h3>
                        <p class="mt-1 text-sm text-blue-700">
                            This commission has been paid to you.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Commission Header -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h1 class="text-3xl font-bold text-gray-800">{{ $tuition->post->post_code }}</h1>
                        @if($tuition->commission_status == 'Waiting Verification')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                Waiting Verification
                            </span>
                        @elseif($tuition->commission_status == 'Pending Approval')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending Approval
                            </span>
                        @elseif($tuition->commission_status == 'Approved')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Approved
                            </span>
                        @elseif($tuition->commission_status == 'Paid')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                Paid
                            </span>
                        @elseif($tuition->commission_status == 'Rejected')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Rejected
                            </span>
                        @endif
                    </div>

                    <!-- Commission Amount Display -->
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg p-6 mb-4">
                        <p class="text-sm opacity-90 mb-1">🔒 Your Commission</p>
                        <p class="text-4xl font-bold">৳{{ number_format($tuition->post->commission_amount) }}</p>
                        <p class="text-sm opacity-90 mt-2">Monthly Salary: ৳{{ number_format($tuition->monthly_salary) }}</p>
                    </div>

                    @if($tuition->commission_rejection_reason)
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <p class="text-sm font-medium text-red-800 mb-1">Rejection Reason:</p>
                            <p class="text-sm text-red-700">{{ $tuition->commission_rejection_reason }}</p>
                        </div>
                    @endif
                </div>

                <!-- Guardian Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Guardian Information</h2>
                    <div class="flex items-start gap-4">
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
                            <p class="text-gray-600">📱 {{ $tuition->guardian->mobile }}</p>
                            @if($tuition->guardian->guardian)
                                <p class="text-gray-600">📍 {{ $tuition->guardian->guardian->area->name ?? 'N/A' }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tutor Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Tutor Information</h2>
                    <div class="flex items-start gap-4">
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
                            <p class="text-gray-600">📱 {{ $tuition->tutor->mobile }}</p>
                            @if($tuition->tutor->tutor)
                                <p class="text-gray-600">📍 {{ $tuition->tutor->tutor->area->name ?? 'N/A' }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Post Details -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Post Details</h2>
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
                    </div>

                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Subjects</p>
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

                <!-- Tuition Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Tuition Information</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <p class="font-semibold text-gray-800">{{ $tuition->status }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Monthly Salary</p>
                            <p class="font-semibold text-blue-600">৳{{ number_format($tuition->monthly_salary) }}</p>
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
                        <div>
                            <p class="text-sm text-gray-500">Tutor Confirmed</p>
                            <p class="font-semibold {{ $tuition->tutor_confirmed_at ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $tuition->tutor_confirmed_at ? 'Yes ✓' : 'No' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Guardian Confirmed</p>
                            <p class="font-semibold {{ $tuition->guardian_confirmed_at ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $tuition->guardian_confirmed_at ? 'Yes ✓' : 'No' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Admin Verified</p>
                            <p class="font-semibold {{ $tuition->admin_verified_at ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $tuition->admin_verified_at ? 'Yes ✓' : 'No' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Commission Timeline -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Commission Timeline</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Post Created</p>
                                <p class="text-xs text-gray-600">{{ $tuition->post->created_at->format('d M Y') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Tuition Started</p>
                                <p class="text-xs text-gray-600">{{ $tuition->created_at->format('d M Y') }}</p>
                            </div>
                        </div>

                        @if($tuition->tutor_confirmed_at && $tuition->guardian_confirmed_at)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Dual Confirmation</p>
                                    <p class="text-xs text-gray-600">Both confirmed</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-600">Dual Confirmation</p>
                                    <p class="text-xs text-gray-500">Waiting...</p>
                                </div>
                            </div>
                        @endif

                        @if($tuition->admin_verified_at)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Admin Verified</p>
                                    <p class="text-xs text-gray-600">{{ $tuition->admin_verified_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-600">Admin Verification</p>
                                    <p class="text-xs text-gray-500">Pending...</p>
                                </div>
                            </div>
                        @endif

                        @if($tuition->commission_status == 'Approved' || $tuition->commission_status == 'Paid')
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Commission Approved</p>
                                    <p class="text-xs text-gray-600">Ready for payout</p>
                                </div>
                            </div>
                        @endif

                        @if($tuition->commission_status == 'Paid')
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Commission Paid</p>
                                    <p class="text-xs text-gray-600">Completed</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Commission Details -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg shadow p-6">
                    <h3 class="font-bold mb-4">Commission Breakdown</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm opacity-90">Commission Amount</p>
                            <p class="text-3xl font-bold">৳{{ number_format($tuition->post->commission_amount) }}</p>
                        </div>
                        <div class="pt-3 border-t border-white border-opacity-20">
                            <p class="text-sm opacity-90">Monthly Salary</p>
                            <p class="text-lg font-semibold">৳{{ number_format($tuition->monthly_salary) }}</p>
                        </div>
                        <div>
                            <p class="text-sm opacity-90">Commission %</p>
                            <p class="text-lg font-semibold">
                                {{ number_format(($tuition->post->commission_amount / $tuition->monthly_salary) * 100, 1) }}%
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
