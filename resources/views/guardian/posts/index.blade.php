@extends('layouts.app')

@section('title', 'My Posts')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">My Tuition Posts</h1>
                <p class="text-gray-600 mt-1">Manage your tuition requirements</p>
            </div>
            <a href="{{ route('guardian.posts.create') }}" 
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Create New Post
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm">Total Posts</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</h3>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm">Active Posts</p>
                <h3 class="text-3xl font-bold text-green-600 mt-1">{{ $stats['active'] }}</h3>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm">Expired Posts</p>
                <h3 class="text-3xl font-bold text-orange-600 mt-1">{{ $stats['expired'] }}</h3>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm">Closed Posts</p>
                <h3 class="text-3xl font-bold text-red-600 mt-1">{{ $stats['closed'] }}</h3>
            </div>
        </div>

        <!-- Posts List -->
        <div class="space-y-4">
            @forelse($posts as $post)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-xl font-bold text-gray-800">{{ $post->post_code }}</h3>
                                @if($post->status == 'Active')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @elseif($post->status == 'Closed')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Closed
                                    </span>
                                @elseif($post->status == 'Expired')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                        Expired
                                    </span>
                                @endif
                            </div>
                            <p class="text-gray-600 text-sm">
                                {{ $post->classLevel->name }} • {{ count($post->preferred_subjects) }} Subjects • {{ $post->area->name }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-blue-600">৳{{ number_format($post->offered_salary) }}</p>
                            <p class="text-gray-500 text-sm">per month</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4 py-4 border-y border-gray-200">
                        <div>
                            <p class="text-xs text-gray-500">Views</p>
                            <p class="font-semibold text-gray-800">{{ $post->view_count }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Applications</p>
                            <p class="font-semibold text-gray-800">{{ $post->application_count }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Tuition Type</p>
                            <p class="font-semibold text-gray-800">{{ $post->tuition_type }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Posted</p>
                            <p class="font-semibold text-gray-800">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('guardian.posts.show', $post->id) }}" 
                            class="px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                            View Details
                        </a>
                        @if($post->status == 'Active')
                            <a href="{{ route('guardian.posts.edit', $post->id) }}" 
                                class="px-4 py-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                                Edit
                            </a>
                            <form action="{{ route('guardian.posts.destroy', $post->id) }}" method="POST" 
                                onsubmit="return confirm('Are you sure you want to delete this post?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    Delete
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No posts yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new tuition post.</p>
                    <div class="mt-6">
                        <a href="{{ route('guardian.posts.create') }}" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors inline-block">
                            Create Post
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
