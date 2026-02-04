@extends('layouts.app')

@section('title', 'Earnings')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Commission Earnings</h1>
            <p class="text-gray-600 mt-1">Track your commission earnings from tuition placements</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                <p class="text-gray-500 text-sm">Pending Approval</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">৳{{ number_format($summary['pending_approval'], 0) }}</h3>
                <p class="text-xs text-gray-500 mt-2">{{ $summary['pending_count'] }} tuitions</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <p class="text-gray-500 text-sm">Approved</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">৳{{ number_format($summary['approved'], 0) }}</h3>
                <p class="text-xs text-gray-500 mt-2">{{ $summary['approved_count'] }} tuitions</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <p class="text-gray-500 text-sm">Paid Out</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">৳{{ number_format($summary['paid'], 0) }}</h3>
                <p class="text-xs text-gray-500 mt-2">{{ $summary['paid_count'] }} tuitions</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                <p class="text-gray-500 text-sm">Total Earnings</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">৳{{ number_format($summary['total'], 0) }}</h3>
                <p class="text-xs text-gray-500 mt-2">All time</p>
            </div>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('partner.earnings.index') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="commission_status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="commission_status" id="commission_status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ request('commission_status') == 'Pending' ? 'selected' : '' }}>Pending Approval</option>
                        <option value="Approved" {{ request('commission_status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Paid" {{ request('commission_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                        <option value="Rejected" {{ request('commission_status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Filter
                    </button>
                    <a href="{{ route('partner.earnings.index') }}" 
                        class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Earnings List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($tuitions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Post Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guardian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tutor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commission</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tuitions as $tuition)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-mono text-sm font-medium text-blue-600">
                                            {{ $tuition->post->post_code }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $tuition->guardian->user->full_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $tuition->tutor->user->full_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        ৳{{ number_format($tuition->commission_amount, 0) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($tuition->commission_status == 'Approved')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Approved
                                            </span>
                                        @elseif($tuition->commission_status == 'Pending')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($tuition->commission_status == 'Paid')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Paid
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $tuition->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('partner.earnings.show', $tuition->id) }}" 
                                            class="text-blue-600 hover:text-blue-900">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $tuitions->links() }}
                </div>
            @else
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No earnings yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Start creating commission posts to earn money.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
