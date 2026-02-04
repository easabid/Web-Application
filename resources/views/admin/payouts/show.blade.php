@extends('layouts.app')

@section('title', 'Payout Management')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Back Button -->
        <a href="{{ route('admin.payouts.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-2 mb-6">
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
                            This payout request is waiting for admin approval.
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
                        <h3 class="text-sm font-medium text-blue-800">Payout Approved</h3>
                        <p class="mt-1 text-sm text-blue-700">
                            This payout has been approved and is ready for processing.
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
                            Payment is currently being processed via {{ $payout->payment_method }}.
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
                            Payment has been successfully transferred to the partner.
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
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg p-6">
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
                                <p class="text-sm opacity-90">Net Payout</p>
                                <p class="text-3xl font-bold">৳{{ number_format($payout->net_amount) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Partner Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Partner Information</h2>
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center">
                            <span class="text-purple-600 font-semibold text-xl">
                                {{ substr($payout->user->first_name, 0, 1) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $payout->user->full_name }}</h3>
                            <p class="text-gray-600">📧 {{ $payout->user->email }}</p>
                            <p class="text-gray-600">📱 {{ $payout->user->mobile }}</p>
                            @if($payout->user->tuitionPartner)
                                <p class="text-gray-600">🏢 {{ $payout->user->tuitionPartner->organization_name }}</p>
                            @endif
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

                <!-- Included Tuitions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Included Commissions ({{ count($payout->tuition_ids) }})</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Post Code</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tutor</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Class</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Salary</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commission</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($payout->tuition_ids as $tuitionId)
                                    @php
                                        $tuition = \App\Models\Tuition::find($tuitionId);
                                    @endphp
                                    @if($tuition)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <a href="{{ route('admin.commissions.show', $tuition->id) }}" 
                                                    class="text-blue-600 hover:text-blue-700 font-medium">
                                                    {{ $tuition->post->post_code }}
                                                </a>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">
                                                {{ $tuition->tutor->full_name }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                                {{ $tuition->post->classLevel->name }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">
                                                ৳{{ number_format($tuition->monthly_salary) }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-purple-600">
                                                ৳{{ number_format($tuition->post->commission_amount) }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if($tuition->commission_status == 'Paid')
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Paid
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        {{ $tuition->commission_status }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-right text-sm font-bold text-gray-800">
                                        Total Gross:
                                    </td>
                                    <td colspan="2" class="px-4 py-3 text-sm font-bold text-purple-600">
                                        ৳{{ number_format($payout->gross_amount) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Admin Actions -->
                @if($payout->status == 'Requested')
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Payout Actions</h2>
                        <div class="flex gap-4">
                            <!-- Approve Form -->
                            <form action="{{ route('admin.payouts.approve', $payout->id) }}" method="POST" class="flex-1"
                                onsubmit="return confirm('Approve this payout for ৳{{ number_format($payout->net_amount) }}?')">
                                @csrf
                                <button type="submit" 
                                    class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                                    ✓ Approve Payout
                                </button>
                            </form>

                            <!-- Reject Button -->
                            <button onclick="document.getElementById('rejectForm').classList.toggle('hidden')"
                                class="flex-1 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold">
                                ✗ Reject Payout
                            </button>
                        </div>

                        <!-- Reject Form (Hidden by default) -->
                        <form id="rejectForm" action="{{ route('admin.payouts.reject', $payout->id) }}" 
                            method="POST" class="mt-4 hidden">
                            @csrf
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Rejection Reason *
                            </label>
                            <textarea name="rejection_reason" rows="3" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                placeholder="Explain why this payout is being rejected..."></textarea>
                            @error('rejection_reason')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div class="flex gap-2 mt-3">
                                <button type="submit" 
                                    class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                                    onclick="return confirm('Reject this payout? Partner will be notified.')">
                                    Submit Rejection
                                </button>
                                <button type="button" onclick="document.getElementById('rejectForm').classList.add('hidden')"
                                    class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                @elseif($payout->status == 'Approved')
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Process Payment</h2>
                        <form action="{{ route('admin.payouts.process', $payout->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Transaction ID *
                                </label>
                                <input type="text" name="transaction_id" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    placeholder="Enter transaction ID from {{ $payout->payment_method }}">
                                @error('transaction_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Notes (Optional)
                                </label>
                                <textarea name="processing_notes" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    placeholder="Add any processing notes..."></textarea>
                            </div>
                            <button type="submit" 
                                class="w-full px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-semibold"
                                onclick="return confirm('Mark this payout as processing?')">
                                Start Processing
                            </button>
                        </form>
                    </div>
                @elseif($payout->status == 'Processing')
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Complete Payment</h2>
                        <form action="{{ route('admin.payouts.complete', $payout->id) }}" method="POST">
                            @csrf
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                <p class="text-sm text-blue-800">
                                    ℹ️ Confirm that the payment has been successfully transferred to the partner's {{ $payout->payment_method }} account.
                                </p>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Completion Notes (Optional)
                                </label>
                                <textarea name="completion_notes" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    placeholder="Add any completion notes..."></textarea>
                            </div>
                            <button type="submit" 
                                class="w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold"
                                onclick="return confirm('Mark this payout as completed? This action cannot be undone.')">
                                ✓ Complete Payout
                            </button>
                        </form>
                    </div>
                @endif
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

                <!-- Quick Stats -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg shadow p-6">
                    <h3 class="font-bold mb-4">Summary</h3>
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
                            <p class="text-sm opacity-90">Net Payout</p>
                            <p class="text-2xl font-bold">৳{{ number_format($payout->net_amount) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
