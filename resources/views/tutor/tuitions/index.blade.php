@extends('layouts.app')

@section('title', 'My Tuitions')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl font-bold text-gray-900">My Tuitions</h1>
            <p class="text-gray-600 mt-1">Manage your ongoing and completed tuitions</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <form method="GET" action="{{ route('tutor.tuitions.index') }}" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">All Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending Confirmation</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Pending Completion" {{ request('status') == 'Pending Completion' ? 'selected' : '' }}>Pending Completion</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                    Apply
                </button>
            </form>
        </div>

        <!-- Tuitions List -->
        @if($tuitions->isEmpty())
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Tuitions Yet</h3>
            <p class="text-gray-600">Your confirmed tuitions will appear here.</p>
        </div>
        @else
        <div class="space-y-4">
            @foreach($tuitions as $tuition)
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            {{ $tuition->student_name }} - Class {{ $tuition->tuitionPost->classLevel->name }}
                        </h3>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p>Guardian: {{ $tuition->guardian->user->first_name }} {{ $tuition->guardian->user->last_name }}</p>
                            <p>Mobile: {{ $tuition->guardian->user->mobile }}</p>
                            <p>Address: {{ $tuition->student_address }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="px-3 py-1 text-sm font-medium rounded-full
                            @if($tuition->status === 'Pending') bg-yellow-100 text-yellow-800
                            @elseif($tuition->status === 'Active') bg-green-100 text-green-800
                            @elseif($tuition->status === 'Completed') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $tuition->status }}
                        </span>
                        <p class="text-2xl font-bold text-green-600 mt-2">৳{{ number_format($tuition->monthly_salary) }}</p>
                        <p class="text-sm text-gray-500">per month</p>
                    </div>
                </div>

                <!-- Confirmation Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Tutor Confirmation</p>
                        @if($tuition->tutor_confirmed_at)
                        <p class="text-green-600 font-medium">✓ Confirmed on {{ $tuition->tutor_confirmed_at->format('M j, Y') }}</p>
                        @else
                        <p class="text-yellow-600 font-medium">⏳ Pending</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Guardian Confirmation</p>
                        @if($tuition->guardian_confirmed_at)
                        <p class="text-green-600 font-medium">✓ Confirmed on {{ $tuition->guardian_confirmed_at->format('M j, Y') }}</p>
                        @else
                        <p class="text-yellow-600 font-medium">⏳ Pending</p>
                        @endif
                    </div>
                </div>

                <!-- Start Date -->
                <div class="mb-4">
                    <p class="text-sm text-gray-500">Start Date: <span class="font-medium text-gray-900">{{ $tuition->start_date->format('F j, Y') }}</span></p>
                </div>

                <div class="flex justify-between items-center pt-4 border-t">
                    <p class="text-sm text-gray-500">Created {{ $tuition->created_at->diffForHumans() }}</p>
                    <div class="flex gap-2">
                        <a href="{{ route('tutor.tuitions.show', $tuition->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                            View Details
                        </a>
                        @if(!$tuition->tutor_confirmed_at && $tuition->status === 'Pending')
                        <form method="POST" action="{{ route('tutor.tuitions.confirm', $tuition->id) }}">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm">
                                Confirm Tuition
                            </button>
                        </form>
                        @endif
                        @if($tuition->status === 'Active')
                        <form method="POST" action="{{ route('tutor.tuitions.mark-completed', $tuition->id) }}" onsubmit="return confirm('Are you sure you want to request completion?')">
                            @csrf
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                                Request Completion
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
            {{ $tuitions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
