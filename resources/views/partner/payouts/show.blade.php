@extends('layouts.app')

@section('title', 'Payout Details')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Back Button -->
        <a href="{{ route('partner.payouts.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-2 mb-6">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Payouts
        </a>

        <!-- Status Alerts -->
        @if($payout->status == 'Requested')
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Payout Requested</h3>
                        <p class="mt-1 text-sm text-yellow-700">
                            Your payout request is being reviewed by admin. You'll be notified once it's approved.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if($payout->status == 'Approved')
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Payout Approved!</h3>
                        <p class="mt-1 text-sm text-blue-700">
                            Your payout has been approved and will be processed soon.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if($payout->status == 'Processing')
            <div class="bg-purple-50 border-l-4 border-purple-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-purple-800">Processing Payment</h3>
                        <p class="mt-1 text-sm text-purple-700">
                            Your payment is being processed. You'll receive it shortly via {{ $payout->payment_method }}.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if($payout->status == 'Completed')
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Payout Completed ✓</h3>
                        <p class="mt-1 text-sm text-green-700">
                            Your payment has been successfully sent to your {{ $payout->payment_method }} account.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if($payout->status == 'Rejected')
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Payout Rejected</h3>
                        <p class="mt-1 text-sm text-red-700">{{ $payout->rejection_reason ?? 'No reason provided' }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Payout Header -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h1 class="text-3xl font-bold text-gray-800">Payout #{{ $payout->id }}</h1>
                        @if($payout->status == 'Requested')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Requested
                            </span>
                        @elseif($payout->status == 'Approved')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                Approved
                            </span>
                        @elseif($payout->status == 'Processing')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                Processing
                            </span>
                        @elseif($payout->status == 'Completed')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Completed
                            </span>
                        @elseif($payout->status == 'Rejected')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Rejected
                            </span>
                        @endif
                    </div>

                    <!-- Amount Breakdown -->
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg p-6">
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm opacity-90">Gross Amount</p>
                                <p class="text-2xl font-bold">৳{{ number_format($payout->gross_amount) }}</p>
                            </div>
                            <div>
                                <p class="text-sm opacity-90">Platform Fee ({{ $payout->platform_fee_percentage }}%)</p>
                                <p class="text-2xl font-bold">-৳{{ number_format($payout->platform_fee_amount) }}</p>
                            </div>
                            <div class="border-l border-white border-opacity-20 pl-4">
                                <p class="text-sm opacity-90">You Receive</p>
                                <p class="text-3xl font-bold">৳{{ number_format($payout->net_amount) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Payment Details</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Payment Method</p>
                            <p class="font-semibold text-gray-800">{{ $payout->payment_method }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Account Number</p>
                            <p class="font-semibold text-gray-800">{{ $payout->payment_account_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Account Name</p>
                            <p class="font-semibold text-gray-800">{{ $payout->payment_account_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Requested Date</p>
                            <p class="font-semibold text-gray-800">{{ $payout->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                        @if($payout->processed_at)
                            <div>
                                <p class="text-sm text-gray-500">Processed Date</p>
                                <p class="font-semibold text-gray-800">{{ $payout->processed_at->format('d M Y, h:i A') }}</p>
                            </div>
                        @endif
                        @if($payout->transaction_id)
                            <div>
                                <p class="text-sm text-gray-500">Transaction ID</p>
                                <p class="font-semibold text-blue-600 font-mono">{{ $payout->transaction_id }}</p>
                            </div>
                        @endif
                    </div>

                    @if($payout->notes)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-500 mb-1">Notes</p>
                            <p class="text-gray-800">{{ $payout->notes }}</p>
                        </div>
                    @endif
                </div>

                <!-- Included Commissions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Included Commissions ({{ count($payout->tuition_ids) }})</h2>
                    <div class="space-y-3">
                        @foreach($payout->tuition_ids as $tuitionId)
                            @php
                                $tuition = \App\Models\Tuition::find($tuitionId);
                            @endphp
                            @if($tuition)
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 transition-colors">
                                    <div class="flex items-center justify-between mb-2">
                                        <a href="{{ route('partner.earnings.show', $tuition->id) }}" 
                                            class="text-lg font-bold text-blue-600 hover:text-blue-700">
                                            {{ $tuition->post->post_code }}
                                        </a>
                                        <span class="text-2xl font-bold text-purple-600">
                                            ৳{{ number_format($tuition->post->commission_amount) }}
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3 text-sm">
                                        <div>
                                            <p class="text-gray-500">Tutor</p>
                                            <p class="font-semibold text-gray-800">{{ $tuition->tutor->full_name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Class</p>
                                            <p class="font-semibold text-gray-800">{{ $tuition->post->classLevel->name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Monthly Salary</p>
                                            <p class="font-semibold text-gray-800">৳{{ number_format($tuition->monthly_salary) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Status</p>
                                            @if($tuition->commission_status == 'Paid')
                                                <p class="font-semibold text-green-600">Paid ✓</p>
                                            @else
                                                <p class="font-semibold text-gray-600">{{ $tuition->commission_status }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Total Summary -->
                    <div class="mt-4 pt-4 border-t-2 border-gray-300">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-800">Total Commission:</span>
                            <span class="text-2xl font-bold text-purple-600">৳{{ number_format($payout->gross_amount) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Timeline -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Payout Timeline</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Requested</p>
                                <p class="text-xs text-gray-600">{{ $payout->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>

                        @if($payout->status != 'Requested' && $payout->status != 'Rejected')
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Approved</p>
                                    <p class="text-xs text-gray-600">By admin</p>
                                </div>
                            </div>
                        @endif

                        @if($payout->status == 'Processing' || $payout->status == 'Completed')
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Processing</p>
                                    <p class="text-xs text-gray-600">Payment initiated</p>
                                </div>
                            </div>
                        @endif

                        @if($payout->status == 'Completed')
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Completed</p>
                                    <p class="text-xs text-gray-600">{{ $payout->processed_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($payout->status == 'Rejected')
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Rejected</p>
                                    <p class="text-xs text-gray-600">By admin</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg shadow p-6">
                    <h3 class="font-bold mb-4">Payment Summary</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm opacity-90">Total Commissions</p>
                            <p class="text-2xl font-bold">{{ count($payout->tuition_ids) }}</p>
                        </div>
                        <div class="pt-3 border-t border-white border-opacity-20">
                            <p class="text-sm opacity-90">Gross Amount</p>
                            <p class="text-lg font-semibold">৳{{ number_format($payout->gross_amount) }}</p>
                        </div>
                        <div>
                            <p class="text-sm opacity-90">Platform Fee</p>
                            <p class="text-lg font-semibold">-৳{{ number_format($payout->platform_fee_amount) }}</p>
                        </div>
                        <div class="pt-3 border-t border-white border-opacity-20">
                            <p class="text-sm opacity-90">Net Payout</p>
                            <p class="text-3xl font-bold">৳{{ number_format($payout->net_amount) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Help Card -->
                @if($payout->status == 'Requested' || $payout->status == 'Approved')
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h3 class="font-bold text-blue-800 mb-2">💡 Need Help?</h3>
                        <p class="text-sm text-blue-700">
                            If you have any questions about your payout, please contact our support team.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
