@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold text-white">Admin Dashboard</h1>
            <p class="text-indigo-100 mt-1">Platform overview and pending actions</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Pending Actions Alert -->
        @if(array_sum($pending) > 0)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mb-8">
            <div class="flex items-start">
                <svg class="h-6 w-6 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <div>
                    <h3 class="text-lg font-medium text-yellow-800 mb-2">Pending Actions Required</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        @if($pending['profile_approvals'] > 0)
                        <a href="{{ route('admin.profiles.index') }}" class="text-yellow-700 hover:text-yellow-900 font-medium">
                            → {{ $pending['profile_approvals'] }} Profile Approvals
                        </a>
                        @endif
                        @if($pending['commission_approvals'] > 0)
                        <a href="{{ route('admin.commissions.index') }}" class="text-yellow-700 hover:text-yellow-900 font-medium">
                            → {{ $pending['commission_approvals'] }} Commission Approvals
                        </a>
                        @endif
                        @if($pending['payout_requests'] > 0)
                        <a href="{{ route('admin.payouts.index') }}" class="text-yellow-700 hover:text-yellow-900 font-medium">
                            → {{ $pending['payout_requests'] }} Payout Requests
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Platform Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm text-gray-500">Total Users</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_users'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm text-gray-500">Active Tutors</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_tutors'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm text-gray-500">Active Posts</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_posts'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm text-gray-500">Active Tuitions</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_tuitions'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Type Breakdown -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tutors</h3>
                <p class="text-3xl font-bold text-green-600 mb-2">{{ $stats['total_tutors'] }}</p>
                <a href="{{ route('admin.users.index', ['type' => 3]) }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all →</a>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Guardians</h3>
                <p class="text-3xl font-bold text-blue-600 mb-2">{{ $stats['total_guardians'] }}</p>
                <a href="{{ route('admin.users.index', ['type' => 4]) }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all →</a>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Partners</h3>
                <p class="text-3xl font-bold text-purple-600 mb-2">{{ $stats['total_partners'] }}</p>
                <a href="{{ route('admin.users.index', ['type' => 5]) }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all →</a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Pending Profiles -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Pending Profile Approvals</h2>
                    <a href="{{ route('admin.profiles.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all →</a>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentProfiles->take(5) as $profile)
                    <div class="px-6 py-4 hover:bg-gray-50">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">
                                    {{ $profile->first_name }} {{ $profile->last_name }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ getUserType($profile->type) }} • {{ $profile->email }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Submitted {{ $profile->profile_completed_at->diffForHumans() }}
                                </p>
                            </div>
                            <a href="{{ route('admin.profiles.show', $profile->id) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                Review →
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        No pending profile approvals
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Tuitions -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Recent Tuitions</h2>
                    <a href="{{ route('admin.tuitions.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all →</a>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentTuitions as $tuition)
                    <div class="px-6 py-4 hover:bg-gray-50">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">
                                    {{ $tuition->student_name }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    Tutor: {{ $tuition->tutor->user->first_name }} • Guardian: {{ $tuition->guardian->user->first_name }}
                                </p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="px-2 py-1 text-xs font-medium rounded
                                        @if($tuition->status === 'Active') bg-green-100 text-green-800
                                        @elseif($tuition->status === 'Pending') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $tuition->status }}
                                    </span>
                                    @if($tuition->has_commission)
                                    <span class="px-2 py-1 text-xs font-medium rounded bg-purple-100 text-purple-800">
                                        Has Commission
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('admin.tuitions.show', $tuition->id) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                View →
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        No recent tuitions
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
