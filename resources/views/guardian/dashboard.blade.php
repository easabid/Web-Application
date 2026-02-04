@extends('layouts.app')

@section('title', 'Guardian Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Welcome, {{ auth()->user()->first_name }}!</h1>
                    <p class="text-gray-600 mt-1">Manage your tuition posts and applications</p>
                </div>
                <a href="{{ route('guardian.posts.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    + Post New Tuition
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Posts -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm text-gray-500">Total Posts</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_posts'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Active Posts -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm text-gray-500">Active Posts</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_posts'] }}</p>
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
                        <p class="text-sm text-gray-500">New Applications</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending_applications'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Active Tuitions -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm text-gray-500">Active Tuitions</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_tuitions'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Posts -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">My Recent Posts</h2>
                    <a href="{{ route('guardian.posts.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all →</a>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentPosts as $post)
                    <div class="px-6 py-4 hover:bg-gray-50">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">
                                    Class {{ $post->classLevel->name }} - {{ $post->area->name }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    Salary: ৳{{ number_format($post->offered_salary) }}/month
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $post->application_count }} applications • {{ $post->view_count }} views
                                </p>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="px-2 py-1 text-xs font-medium rounded
                                    @if($post->status === 'Active') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $post->status }}
                                </span>
                                <span class="text-xs text-gray-500 mt-2">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        No posts yet. <a href="{{ route('guardian.posts.create') }}" class="text-indigo-600 hover:text-indigo-700">Create your first post</a>!
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Applications -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Recent Applications</h2>
                    <a href="{{ route('guardian.applications.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all →</a>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentApplications as $application)
                    <div class="px-6 py-4 hover:bg-gray-50">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">
                                    {{ $application->tutor->user->first_name }} {{ $application->tutor->user->last_name }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    Applied to: Class {{ $application->tuitionPost->classLevel->name }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Expected: ৳{{ number_format($application->expected_salary) }}/month
                                </p>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="px-2 py-1 text-xs font-medium rounded
                                    @if($application->status === 'Pending') bg-yellow-100 text-yellow-800
                                    @elseif($application->status === 'Shortlisted') bg-blue-100 text-blue-800
                                    @elseif($application->status === 'Accepted') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $application->status }}
                                </span>
                                <a href="{{ route('guardian.applications.show', $application->id) }}" class="text-sm text-indigo-600 hover:text-indigo-700 mt-2">
                                    View →
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        No applications received yet.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
