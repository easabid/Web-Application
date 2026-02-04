@extends('layouts.app')

@section('title', 'Active Tuitions')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">My Tuitions</h1>
            <p class="text-gray-600 mt-1">Manage your active and ongoing tuitions</p>
        </div>

        <!-- Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <a href="{{ route('guardian.tuitions.index', ['filter' => 'active']) }}" 
                    class="border-b-2 py-4 px-1 text-sm font-medium {{ request('filter', 'active') == 'active' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Active ({{ $activeCount }})
                </a>
                <a href="{{ route('guardian.tuitions.index', ['filter' => 'pending']) }}" 
                    class="border-b-2 py-4 px-1 text-sm font-medium {{ request('filter') == 'pending' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Pending Confirmation ({{ $pendingCount }})
                </a>
                <a href="{{ route('guardian.tuitions.index', ['filter' => 'completed']) }}" 
                    class="border-b-2 py-4 px-1 text-sm font-medium {{ request('filter') == 'completed' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Completed ({{ $completedCount }})
                </a>
            </nav>
        </div>

        <!-- Tuitions List -->
        <div class="space-y-4">
            @forelse($tuitions as $tuition)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-xl font-bold text-gray-800">{{ $tuition->post->post_code }}</h3>
                                @if($tuition->status == 'Active')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @elseif($tuition->status == 'Pending')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending Confirmation
                                    </span>
                                @elseif($tuition->status == 'Completed')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Completed
                                    </span>
                                @endif
                            </div>
                            <p class="text-gray-600 text-sm">
                                {{ $tuition->post->classLevel->name }} • {{ $tuition->post->area->name }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">Monthly Salary</p>
                            <p class="text-2xl font-bold text-blue-600">৳{{ number_format($tuition->monthly_salary) }}</p>
                        </div>
                    </div>

                    <!-- Tutor Info -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="flex items-center gap-4">
                            @if($tuition->tutor->photo)
                                <img src="{{ asset('storage/' . $tuition->tutor->photo) }}" 
                                    alt="Photo" class="w-12 h-12 rounded-full object-cover">
                            @else
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 font-semibold">
                                        {{ substr($tuition->tutor->user->first_name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                            <div class="flex-1">
                                <p class="text-xs text-gray-500">Tutor</p>
                                <p class="font-semibold text-gray-800">{{ $tuition->tutor->user->full_name }}</p>
                                <p class="text-xs text-gray-600">{{ $tuition->tutor->user->mobile }}</p>
                            </div>
                            @if($tuition->tutor->average_rating)
                                <div class="text-right">
                                    <div class="flex items-center gap-1">
                                        <span class="text-yellow-500">★</span>
                                        <span class="font-semibold text-gray-800">
                                            {{ number_format($tuition->tutor->average_rating, 1) }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Confirmation Status -->
                    @if($tuition->status == 'Pending' || $tuition->status == 'Active')
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="bg-{{ $tuition->tutor_confirmed_at ? 'green' : 'gray' }}-50 rounded-lg p-3">
                                <div class="flex items-center gap-2">
                                    @if($tuition->tutor_confirmed_at)
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                    <div>
                                        <p class="text-xs text-gray-500">Tutor Confirmation</p>
                                        <p class="font-semibold text-{{ $tuition->tutor_confirmed_at ? 'green' : 'gray' }}-700">
                                            {{ $tuition->tutor_confirmed_at ? $tuition->tutor_confirmed_at->format('d M Y') : 'Waiting' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-{{ $tuition->guardian_confirmed_at ? 'green' : 'yellow' }}-50 rounded-lg p-3">
                                <div class="flex items-center gap-2">
                                    @if($tuition->guardian_confirmed_at)
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                    <div>
                                        <p class="text-xs text-gray-500">Your Confirmation</p>
                                        <p class="font-semibold text-{{ $tuition->guardian_confirmed_at ? 'green' : 'yellow' }}-700">
                                            {{ $tuition->guardian_confirmed_at ? $tuition->guardian_confirmed_at->format('d M Y') : 'Action Required' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Dates -->
                    <div class="grid grid-cols-3 gap-4 mb-4 py-4 border-t border-gray-200">
                        <div>
                            <p class="text-xs text-gray-500">Started</p>
                            <p class="font-semibold text-gray-800">{{ $tuition->start_date->format('d M Y') }}</p>
                        </div>
                        @if($tuition->end_date)
                            <div>
                                <p class="text-xs text-gray-500">Ended</p>
                                <p class="font-semibold text-gray-800">{{ $tuition->end_date->format('d M Y') }}</p>
                            </div>
                        @endif
                        @if($tuition->admin_verified_at)
                            <div>
                                <p class="text-xs text-gray-500">Admin Verified</p>
                                <p class="font-semibold text-gray-800">{{ $tuition->admin_verified_at->format('d M Y') }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('guardian.tuitions.show', $tuition->id) }}" 
                            class="px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                            View Details
                        </a>
                        @if($tuition->status == 'Pending' && !$tuition->guardian_confirmed_at)
                            <form action="{{ route('guardian.tuitions.confirm', $tuition->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    Confirm Tuition
                                </button>
                            </form>
                        @endif
                        @if($tuition->status == 'Active' && !$tuition->end_date)
                            <a href="{{ route('guardian.tuitions.complete', $tuition->id) }}" 
                                class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                                Mark as Complete
                            </a>
                        @endif
                        @if($tuition->status == 'Completed' && !$tuition->is_reviewed_by_guardian)
                            <a href="{{ route('guardian.tuitions.review', $tuition->id) }}" 
                                class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                                Write Review
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No tuitions found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if(request('filter') == 'pending')
                            No tuitions waiting for confirmation.
                        @elseif(request('filter') == 'completed')
                            No completed tuitions yet.
                        @else
                            No active tuitions. Accept applications to get started.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($tuitions->hasPages())
            <div class="mt-6">
                {{ $tuitions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
