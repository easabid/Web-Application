@extends('layouts.app')

@section('title', 'Applications')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Tuition Applications</h1>
            <p class="text-gray-600 mt-1">Manage applications for your tuition posts</p>
        </div>

        <!-- Filter by Post -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('guardian.applications.index') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[250px]">
                    <label for="post_id" class="block text-sm font-medium text-gray-700 mb-1">Filter by Post</label>
                    <select name="post_id" id="post_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All Posts</option>
                        @foreach($myPosts as $post)
                            <option value="{{ $post->id }}" {{ request('post_id') == $post->id ? 'selected' : '' }}>
                                {{ $post->post_code }} - {{ $post->classLevel->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Shortlisted" {{ request('status') == 'Shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                        <option value="Accepted" {{ request('status') == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Filter
                    </button>
                    <a href="{{ route('guardian.applications.index') }}" 
                        class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Applications List -->
        @if($applications->count() > 0)
            <div class="space-y-4">
                @foreach($applications as $application)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-start gap-4">
                                @if($application->tutor->photo)
                                    <img src="{{ asset('storage/' . $application->tutor->photo) }}" 
                                        alt="Photo" class="w-16 h-16 rounded-full object-cover">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-600 font-semibold text-xl">
                                            {{ substr($application->tutor->user->first_name, 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">
                                        {{ $application->tutor->user->full_name }}
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        {{ $application->tutor->gender }} • {{ $application->tutor->area->name }}
                                    </p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-yellow-500">★</span>
                                        <span class="text-sm text-gray-600">
                                            {{ number_format($application->tutor->average_rating ?? 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($application->status == 'Pending')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @elseif($application->status == 'Shortlisted')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Shortlisted
                                    </span>
                                @elseif($application->status == 'Accepted')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Accepted
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Rejected
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Post Info -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500">Applied For</p>
                                    <p class="font-semibold text-gray-800">{{ $application->post->post_code }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $application->post->classLevel->name }} • {{ $application->post->area->name }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">Expected Salary</p>
                                    <p class="text-lg font-bold text-blue-600">
                                        ৳{{ number_format($application->expected_salary) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Cover Letter -->
                        @if($application->cover_letter)
                            <div class="mb-4">
                                <p class="text-xs font-medium text-gray-500 mb-1">Cover Letter</p>
                                <p class="text-sm text-gray-700 line-clamp-2">{{ $application->cover_letter }}</p>
                            </div>
                        @endif>

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <span class="text-xs text-gray-500">
                                Applied {{ $application->created_at->diffForHumans() }}
                            </span>
                            <div class="flex gap-2">
                                <a href="{{ route('guardian.applications.show', $application->id) }}" 
                                    class="px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors text-sm font-medium">
                                    View Details
                                </a>
                                @if($application->status == 'Pending')
                                    <form action="{{ route('guardian.applications.shortlist', $application->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                            Shortlist
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $applications->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No applications yet</h3>
                <p class="mt-1 text-sm text-gray-500">Applications will appear here when tutors apply to your posts.</p>
            </div>
        @endif
    </div>
</div>
@endsection
