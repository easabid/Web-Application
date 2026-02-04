@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Back Button -->
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-2 mb-6">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Users
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- User Header -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-start gap-4 mb-4">
                        @if($user->type == 3 && $user->tutor && $user->tutor->photo)
                            <img src="{{ asset('storage/' . $user->tutor->photo) }}" 
                                alt="Photo" class="w-20 h-20 rounded-full object-cover">
                        @elseif($user->type == 4 && $user->guardian && $user->guardian->photo)
                            <img src="{{ asset('storage/' . $user->guardian->photo) }}" 
                                alt="Photo" class="w-20 h-20 rounded-full object-cover">
                        @else
                            <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-semibold text-2xl">
                                    {{ substr($user->first_name, 0, 1) }}
                                </span>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-800">{{ $user->full_name }}</h1>
                            <p class="text-gray-600">{{ $user->email }}</p>
                            <div class="flex items-center gap-3 mt-2">
                                @if($user->type == 3)
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Tutor
                                    </span>
                                @elseif($user->type == 4)
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Guardian
                                    </span>
                                @elseif($user->type == 5)
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                        Partner
                                    </span>
                                @endif

                                @if($user->is_suspended)
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Suspended
                                    </span>
                                @elseif($user->profile_approved_at)
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Approved
                                    </span>
                                @elseif($user->profile_rejected_at)
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Rejected
                                    </span>
                                @elseif($user->profile_completed_at)
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending Approval
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Incomplete Profile
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Account Information</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">User ID</p>
                            <p class="font-semibold text-gray-800">#{{ $user->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Mobile</p>
                            <p class="font-semibold text-gray-800">{{ $user->mobile }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email Verified</p>
                            <p class="font-semibold {{ $user->email_verified_at ? 'text-green-600' : 'text-red-600' }}">
                                {{ $user->email_verified_at ? 'Yes ✓' : 'No' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Last Login</p>
                            <p class="font-semibold text-gray-800">
                                {{ $user->last_login_at ? $user->last_login_at->format('d M Y, h:i A') : 'Never' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Registered</p>
                            <p class="font-semibold text-gray-800">{{ $user->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Referral Code</p>
                            <p class="font-semibold text-gray-800 font-mono">{{ $user->referral_code }}</p>
                        </div>
                    </div>

                    @if($user->referred_by_code)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-500">Referred By</p>
                            <p class="font-semibold text-gray-800">{{ $user->referred_by_code }}</p>
                        </div>
                    @endif
                </div>

                <!-- Profile Details (Type Specific) -->
                @if($user->type == 3 && $user->tutor)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Tutor Profile</h2>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Gender</p>
                                <p class="font-semibold text-gray-800">{{ $user->tutor->gender }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Area</p>
                                <p class="font-semibold text-gray-800">{{ $user->tutor->area->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Salary Range</p>
                                <p class="font-semibold text-blue-600">
                                    ৳{{ number_format($user->tutor->expected_minimum_salary) }} - ৳{{ number_format($user->tutor->expected_maximum_salary) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Tuitions</p>
                                <p class="font-semibold text-gray-800">{{ $user->tutor->tuitions_count ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-2">Subjects ({{ count($user->tutor->subjects) }})</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach(array_slice($user->tutor->subjects, 0, 5) as $subjectId)
                                    @php $subject = \App\Models\Subject::find($subjectId); @endphp
                                    @if($subject)
                                        <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs">{{ $subject->name }}</span>
                                    @endif
                                @endforeach
                                @if(count($user->tutor->subjects) > 5)
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">+{{ count($user->tutor->subjects) - 5 }} more</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Qualifications</p>
                            <p class="font-semibold text-gray-800">{{ $user->tutor->qualifications->count() }} added</p>
                        </div>
                    </div>
                @elseif($user->type == 4 && $user->guardian)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Guardian Profile</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Relation</p>
                                <p class="font-semibold text-gray-800">{{ $user->guardian->relation_to_student }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Area</p>
                                <p class="font-semibold text-gray-800">{{ $user->guardian->area->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Posts</p>
                                <p class="font-semibold text-gray-800">{{ $user->guardian->posts_count ?? 0 }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Active Tuitions</p>
                                <p class="font-semibold text-gray-800">{{ $user->guardian->tuitions_count ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                @elseif($user->type == 5 && $user->tuitionPartner)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Partner Profile</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Organization</p>
                                <p class="font-semibold text-gray-800">{{ $user->tuitionPartner->organization_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Posts</p>
                                <p class="font-semibold text-gray-800">{{ $user->tuitionPartner->posts_count ?? 0 }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Earnings</p>
                                <p class="font-semibold text-purple-600">৳{{ number_format($user->tuitionPartner->total_earnings ?? 0) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Payment Method</p>
                                <p class="font-semibold text-gray-800">{{ $user->tuitionPartner->payment_method }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Activity Log -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Profile Timeline</h2>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Account Created</p>
                                <p class="text-sm text-gray-600">{{ $user->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>

                        @if($user->email_verified_at)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Email Verified</p>
                                    <p class="text-sm text-gray-600">{{ $user->email_verified_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($user->profile_completed_at)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Profile Completed</p>
                                    <p class="text-sm text-gray-600">{{ $user->profile_completed_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($user->profile_approved_at)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Profile Approved</p>
                                    <p class="text-sm text-gray-600">{{ $user->profile_approved_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($user->profile_rejected_at)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Profile Rejected</p>
                                    <p class="text-sm text-gray-600">{{ $user->profile_rejected_at->format('d M Y, h:i A') }}</p>
                                    @if($user->profile_rejection_reason)
                                        <p class="text-sm text-red-600 mt-1">{{ $user->profile_rejection_reason }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if($user->is_suspended)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Account Suspended</p>
                                    <p class="text-sm text-gray-600">{{ $user->suspended_at ? $user->suspended_at->format('d M Y, h:i A') : 'N/A' }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Actions</h3>
                    <div class="space-y-2">
                        @if(!$user->is_suspended)
                            <form action="{{ route('admin.users.suspend', $user->id) }}" method="POST"
                                onsubmit="return confirm('Suspend this user account?')">
                                @csrf
                                <button type="submit" 
                                    class="w-full px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                                    Suspend Account
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.users.unsuspend', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                    class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    Unsuspend Account
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                            onsubmit="return confirm('Permanently delete this user? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                Delete Account
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow p-6">
                    <h3 class="font-bold mb-4">Quick Stats</h3>
                    <div class="space-y-3">
                        @if($user->type == 3 && $user->tutor)
                            <div>
                                <p class="text-sm opacity-90">Total Applications</p>
                                <p class="text-2xl font-bold">{{ $user->tutor->applications_count ?? 0 }}</p>
                            </div>
                            <div>
                                <p class="text-sm opacity-90">Active Tuitions</p>
                                <p class="text-2xl font-bold">{{ $user->tutor->active_tuitions_count ?? 0 }}</p>
                            </div>
                        @elseif($user->type == 4 && $user->guardian)
                            <div>
                                <p class="text-sm opacity-90">Total Posts</p>
                                <p class="text-2xl font-bold">{{ $user->guardian->posts_count ?? 0 }}</p>
                            </div>
                            <div>
                                <p class="text-sm opacity-90">Active Tuitions</p>
                                <p class="text-2xl font-bold">{{ $user->guardian->tuitions_count ?? 0 }}</p>
                            </div>
                        @elseif($user->type == 5 && $user->tuitionPartner)
                            <div>
                                <p class="text-sm opacity-90">Total Commissions</p>
                                <p class="text-2xl font-bold">{{ $user->tuitionPartner->commissions_count ?? 0 }}</p>
                            </div>
                            <div>
                                <p class="text-sm opacity-90">Total Earnings</p>
                                <p class="text-2xl font-bold">৳{{ number_format($user->tuitionPartner->total_earnings ?? 0) }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
