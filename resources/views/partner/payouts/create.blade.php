@extends('layouts.app')

@section('title', 'Request Payout')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Request Payout</h1>
            <p class="text-gray-600 mt-1">Request withdrawal of your approved commissions</p>
        </div>

        <!-- Balance Summary -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Available Balance</h3>
            <div class="flex items-center justify-between mb-4">
                <span class="text-gray-600">Approved Commissions</span>
                <span class="text-2xl font-bold text-green-600">৳{{ number_format($partner->pending_payout, 0) }}</span>
            </div>
            <p class="text-sm text-gray-500">
                Platform fee ({{ config('findtutors.PLATFORM_FEE_PERCENTAGE') }}%) will be deducted from the gross amount.
            </p>
        </div>

        <!-- Approved Tuitions -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Select Commissions to Include</h3>
            
            @if($approvedTuitions->count() > 0)
                <form action="{{ route('partner.payouts.store') }}" method="POST" id="payoutForm">
                    @csrf

                    <div class="space-y-3 mb-6">
                        <label class="flex items-center p-4 border-2 border-blue-600 bg-blue-50 rounded-lg cursor-pointer">
                            <input type="checkbox" id="selectAll" checked
                                class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-3 font-semibold text-blue-800">Select All ({{ $approvedTuitions->count() }} tuitions)</span>
                        </label>

                        @foreach($approvedTuitions as $tuition)
                            <label class="flex items-start p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer tuition-item">
                                <input type="checkbox" name="tuition_ids[]" value="{{ $tuition->id }}" 
                                    checked data-amount="{{ $tuition->commission_amount }}"
                                    class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-1 tuition-checkbox">
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-mono text-sm font-medium text-blue-600">
                                                {{ $tuition->post->post_code }}
                                            </span>
                                            <span class="text-sm text-gray-600 ml-2">
                                                {{ $tuition->guardian->user->full_name }}
                                            </span>
                                        </div>
                                        <span class="text-lg font-bold text-gray-900">
                                            ৳{{ number_format($tuition->commission_amount, 0) }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        Approved: {{ $tuition->commission_approved_at->format('d M Y') }}
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    @error('tuition_ids')
                        <p class="text-sm text-red-600 mb-4">{{ $message }}</p>
                    @enderror

                    <!-- Summary -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h4 class="font-bold text-gray-800 mb-4">Payout Summary</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Gross Amount</span>
                                <span class="font-semibold text-gray-900" id="grossAmount">৳0</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Platform Fee ({{ config('findtutors.PLATFORM_FEE_PERCENTAGE') }}%)</span>
                                <span class="font-semibold text-red-600" id="platformFee">-৳0</span>
                            </div>
                            <div class="border-t pt-3 flex justify-between">
                                <span class="text-lg font-bold text-gray-800">You Will Receive</span>
                                <span class="text-2xl font-bold text-green-600" id="netAmount">৳0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-blue-800 mb-2">Payment Details</h4>
                        <div class="text-sm text-blue-700">
                            <p><strong>Method:</strong> {{ $partner->payment_method }}</p>
                            <p><strong>Details:</strong> {{ $partner->payment_details }}</p>
                        </div>
                        <a href="{{ route('partner.profile.edit') }}" class="text-xs text-blue-600 hover:text-blue-800 mt-2 inline-block">
                            Update payment details
                        </a>
                    </div>

                    <!-- Notes -->
                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes (Optional)
                        </label>
                        <textarea id="notes" name="notes" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Any additional notes for the admin...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="flex items-center justify-between pt-4 border-t">
                        <a href="{{ route('partner.payouts.index') }}" class="text-gray-600 hover:text-gray-800">
                            Cancel
                        </a>
                        <button type="submit" id="submitBtn" disabled
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold disabled:opacity-50 disabled:cursor-not-allowed">
                            Request Payout
                        </button>
                    </div>
                </form>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-600">No approved commissions available for payout.</p>
                    <a href="{{ route('partner.earnings.index') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">
                        View Earnings
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
const platformFeePercentage = {{ config('findtutors.PLATFORM_FEE_PERCENTAGE') }};

function calculateTotals() {
    let grossAmount = 0;
    document.querySelectorAll('.tuition-checkbox:checked').forEach(checkbox => {
        grossAmount += parseFloat(checkbox.dataset.amount);
    });

    const platformFee = grossAmount * (platformFeePercentage / 100);
    const netAmount = grossAmount - platformFee;

    document.getElementById('grossAmount').textContent = '৳' + Math.round(grossAmount).toLocaleString();
    document.getElementById('platformFee').textContent = '-৳' + Math.round(platformFee).toLocaleString();
    document.getElementById('netAmount').textContent = '৳' + Math.round(netAmount).toLocaleString();

    // Enable/disable submit button
    const submitBtn = document.getElementById('submitBtn');
    const checkedCount = document.querySelectorAll('.tuition-checkbox:checked').length;
    submitBtn.disabled = checkedCount === 0;
}

// Select All functionality
document.getElementById('selectAll').addEventListener('change', function() {
    document.querySelectorAll('.tuition-checkbox').forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    calculateTotals();
});

// Individual checkbox change
document.querySelectorAll('.tuition-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        calculateTotals();
        
        // Update Select All state
        const totalCheckboxes = document.querySelectorAll('.tuition-checkbox').length;
        const checkedCheckboxes = document.querySelectorAll('.tuition-checkbox:checked').length;
        document.getElementById('selectAll').checked = totalCheckboxes === checkedCheckboxes;
    });
});

// Initial calculation
calculateTotals();
</script>
@endsection
