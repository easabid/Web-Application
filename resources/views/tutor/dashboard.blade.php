@extends('layouts.app')

@section('title', 'Tutor Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Welcome, {{ auth()->user()->first_name }}!</h1>
                    <p class="text-gray-600 mt-1">Manage your tuition applications and opportunities</p>
                </div>
                <a href="{{ route('tutor.posts.index') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    Browse Tuition Posts
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Profile Completion Alert -->
        @if(!$profileComplete)
        <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Your profile is incomplete. Please <a href="{{ route('tutor.profile.edit') }}" class="font-medium underline">complete your profile</a> to start applying for tuitions.
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Applications -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm text-gray-500">Total Applications</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_applications'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Pending Applications -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm text-gray-500">Pending</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending_applications'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Active Tuitions -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm text-gray-500">Active Tuitions</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_tuitions'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Earnings -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm text-gray-500">Total Earnings</p>
                        <p class="text-2xl font-semibold text-gray-900">৳{{ number_format($stats['total_earnings']) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Applications -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Recent Applications</h2>
                    <a href="{{ route('tutor.applications.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all →</a>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentApplications as $application)
                    <div class="px-6 py-4 hover:bg-gray-50">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">
                                    {{ $application->tuitionPost->area->name }} - Class {{ $application->tuitionPost->classLevel->name }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    Posted by {{ $application->tuitionPost->guardian->user->first_name }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Applied {{ $application->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                @if($application->status === 'Pending') bg-yellow-100 text-yellow-800
                                @elseif($application->status === 'Shortlisted') bg-blue-100 text-blue-800
                                @elseif($application->status === 'Accepted') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $application->status }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        No applications yet. <a href="{{ route('tutor.posts.index') }}" class="text-indigo-600 hover:text-indigo-700">Browse posts</a> to get started!
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Active Tuitions -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Active Tuitions</h2>
                    <a href="{{ route('tutor.tuitions.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all →</a>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($activeTuitions as $tuition)
                    <div class="px-6 py-4 hover:bg-gray-50">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">
                                    {{ $tuition->student_name }} - Class {{ $tuition->tuitionPost->classLevel->name }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    Guardian: {{ $tuition->guardian->user->first_name }} {{ $tuition->guardian->user->last_name }}
                                </p>
                                <p class="text-sm text-green-600 font-medium mt-1">
                                    ৳{{ number_format($tuition->monthly_salary) }}/month
                                </p>
                            </div>
                            <a href="{{ route('tutor.tuitions.show', $tuition->id) }}" class="text-indigo-600 hover:text-indigo-700">
                                View →
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        No active tuitions yet.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
