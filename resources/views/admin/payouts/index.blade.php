@extends('layouts.app')

@section('title', 'Payout Requests')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Payout Requests</h1>
            <p class="text-gray-600 mt-1">Manage partner commission payout requests</p>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('admin.payouts.index') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All Statuses</option>
                        <option value="Requested" {{ request('status') == 'Requested' ? 'selected' : '' }}>Requested</option>
                        <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Processing" {{ request('status') == 'Processing' ? 'selected' : '' }}>Processing</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Filter
                    </button>
                    <a href="{{ route('admin.payouts.index') }}" 
                        class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm">Requested</p>
                <h3 class="text-2xl font-bold text-yellow-600 mt-1">{{ $stats['requested_count'] }}</h3>
                <p class="text-sm text-gray-600 mt-1">৳{{ number_format($stats['requested_amount'], 0) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm">Approved</p>
                <h3 class="text-2xl font-bold text-green-600 mt-1">{{ $stats['approved_count'] }}</h3>
                <p class="text-sm text-gray-600 mt-1">৳{{ number_format($stats['approved_amount'], 0) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm">Processing</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-1">{{ $stats['processing_count'] }}</h3>
                <p class="text-sm text-gray-600 mt-1">৳{{ number_format($stats['processing_amount'], 0) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm">Completed</p>
                <h3 class="text-2xl font-bold text-purple-600 mt-1">{{ $stats['completed_count'] }}</h3>
                <p class="text-sm text-gray-600 mt-1">৳{{ number_format($stats['completed_amount'], 0) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm">Rejected</p>
                <h3 class="text-2xl font-bold text-red-600 mt-1">{{ $stats['rejected_count'] }}</h3>
                <p class="text-sm text-gray-600 mt-1">৳{{ number_format($stats['rejected_amount'], 0) }}</p>
            </div>
        </div>

        <!-- Payouts List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($payouts->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payout ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Partner</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gross Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Platform Fee</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Net Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($payouts as $payout)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-mono text-sm font-medium text-gray-900">#{{ $payout->id }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $payout->partner->user->full_name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $payout->partner->organization_name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        ৳{{ number_format($payout->gross_amount, 0) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">
                                        -৳{{ number_format($payout->platform_fee_amount, 0) }}
                                        <span class="text-xs text-gray-500">({{ $payout->platform_fee_percentage }}%)</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                                        ৳{{ number_format($payout->net_amount, 0) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $payout->payment_method }}</div>
                                        <div class="text-xs text-gray-500">{{ Str::limit($payout->payment_details, 20) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($payout->status == 'Requested')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Requested
                                            </span>
                                        @elseif($payout->status == 'Approved')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Approved
                                            </span>
                                        @elseif($payout->status == 'Processing')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Processing
                                            </span>
                                        @elseif($payout->status == 'Completed')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                                Completed
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.payouts.show', $payout->id) }}" 
                                            class="text-blue-600 hover:text-blue-900">
                                            Manage
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $payouts->links() }}
                </div>
            @else
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No payout requests</h3>
                    <p class="mt-1 text-sm text-gray-500">There are no payout requests to display.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
