@extends('layouts.app')

@section('title', 'My Payouts')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Commission Payouts</h1>
                <p class="text-gray-600 mt-1">Request and track your commission payouts</p>
            </div>
            @if($canRequestPayout)
                <a href="{{ route('partner.payouts.create') }}" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Request Payout
                </a>
            @endif
        </div>

        <!-- Balance Card -->
        <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-lg shadow-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-white">
                <div>
                    <p class="text-green-100 text-sm mb-1">Available Balance</p>
                    <h2 class="text-4xl font-bold">৳{{ number_format($partner->pending_payout, 0) }}</h2>
                    @if($partner->pending_payout >= config('findtutors.MINIMUM_PAYOUT_AMOUNT'))
                        <p class="text-green-100 text-xs mt-2">✓ Eligible for withdrawal</p>
                    @else
                        <p class="text-green-100 text-xs mt-2">
                            Minimum: ৳{{ number_format(config('findtutors.MINIMUM_PAYOUT_AMOUNT'), 0) }}
                        </p>
                    @endif
                </div>
                <div>
                    <p class="text-green-100 text-sm mb-1">Total Earnings</p>
                    <h2 class="text-4xl font-bold">৳{{ number_format($partner->total_earnings, 0) }}</h2>
                    <p class="text-green-100 text-xs mt-2">All approved commissions</p>
                </div>
                <div>
                    <p class="text-green-100 text-sm mb-1">Total Withdrawn</p>
                    <h2 class="text-4xl font-bold">৳{{ number_format($partner->total_paid, 0) }}</h2>
                    <p class="text-green-100 text-xs mt-2">Successfully paid out</p>
                </div>
            </div>
        </div>

        <!-- Payout Information -->
        @if(!$canRequestPayout)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Minimum payout amount is ৳{{ number_format(config('findtutors.MINIMUM_PAYOUT_AMOUNT'), 0) }}. 
                            Your current balance is ৳{{ number_format($partner->pending_payout, 0) }}.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Payout History -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-800">Payout History</h3>
            </div>

            @if($payouts->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payout ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gross Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Platform Fee</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Net Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($payouts as $payout)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-mono text-sm font-medium text-gray-900">#{{ $payout->id }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        ৳{{ number_format($payout->gross_amount, 0) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">
                                        -৳{{ number_format($payout->platform_fee_amount, 0) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                                        ৳{{ number_format($payout->net_amount, 0) }}
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $payout->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('partner.payouts.show', $payout->id) }}" 
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
                    {{ $payouts->links() }}
                </div>
            @else
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No payout history</h3>
                    <p class="mt-1 text-sm text-gray-500">You haven't requested any payouts yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
