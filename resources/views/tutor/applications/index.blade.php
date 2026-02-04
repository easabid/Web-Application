@extends('layouts.app')

@section('title', 'My Applications')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl font-bold text-gray-900">My Applications</h1>
            <p class="text-gray-600 mt-1">Track your tuition applications and their status</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <form method="GET" action="{{ route('tutor.applications.index') }}" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">All Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Viewed" {{ request('status') == 'Viewed' ? 'selected' : '' }}>Viewed</option>
                        <option value="Shortlisted" {{ request('status') == 'Shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                        <option value="Accepted" {{ request('status') == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="Withdrawn" {{ request('status') == 'Withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                    </select>
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                    Apply
                </button>
                @if(request('status'))
                <a href="{{ route('tutor.applications.index') }}" class="text-gray-600 hover:text-gray-800">
                    Clear
                </a>
                @endif
            </form>
        </div>

        <!-- Applications List -->
        @if($applications->isEmpty())
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Applications Found</h3>
            <p class="text-gray-600 mb-4">Start applying to tuition posts to see them here.</p>
            <a href="{{ route('tutor.posts.index') }}" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                Browse Posts
            </a>
        </div>
        @else
        <div class="space-y-4">
            @foreach($applications as $application)
            <div class="bg-white rounded-lg shadow hover:shadow-md transition p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            Class {{ $application->tuitionPost->classLevel->name }} - {{ $application->tuitionPost->area->name }}
                        </h3>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p>Guardian: {{ $application->tuitionPost->guardian->user->first_name }} {{ substr($application->tuitionPost->guardian->user->last_name, 0, 1) }}.</p>
                            <p>Offered Salary: ৳{{ number_format($application->tuitionPost->offered_salary) }}/month</p>
                            <p>Your Expected: ৳{{ number_format($application->expected_salary) }}/month</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-sm font-medium rounded-full
                        @if($application->status === 'Pending') bg-yellow-100 text-yellow-800
                        @elseif($application->status === 'Viewed') bg-blue-100 text-blue-800
                        @elseif($application->status === 'Shortlisted') bg-purple-100 text-purple-800
                        @elseif($application->status === 'Accepted') bg-green-100 text-green-800
                        @elseif($application->status === 'Rejected') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ $application->status }}
                    </span>
                </div>

                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-700">{{ Str::limit($application->cover_letter, 150) }}</p>
                </div>

                <div class="flex justify-between items-center pt-4 border-t">
                    <p class="text-sm text-gray-500">Applied {{ $application->created_at->diffForHumans() }}</p>
                    <div class="flex gap-2">
                        <a href="{{ route('tutor.applications.show', $application->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                            View Details
                        </a>
                        @if($application->canWithdraw())
                        <form method="POST" action="{{ route('tutor.applications.destroy', $application->id) }}" onsubmit="return confirm('Are you sure you want to withdraw this application?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm">
                                Withdraw
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
        @endif
    </div>
</div>
@endsection
