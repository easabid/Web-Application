@extends('layouts.app')

@section('title', 'Create Partner Profile')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-3xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Create Tuition Partner Profile</h2>
            <p class="text-gray-600 mb-6">Register your organization to post tuition opportunities and earn commissions.</p>

            <form action="{{ route('partner.profile.store') }}" method="POST">
                @csrf

                <!-- Organization Name -->
                <div class="mb-6">
                    <label for="organization_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Organization Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="organization_name" name="organization_name" 
                        value="{{ old('organization_name') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter organization name">
                    @error('organization_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Coverage Areas -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Coverage Areas <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-gray-500 mb-3">Select all areas where you can provide tuition services</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-64 overflow-y-auto border border-gray-200 rounded-lg p-4">
                        @foreach($areas as $area)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="coverage_areas[]" value="{{ $area->id }}"
                                    {{ in_array($area->id, old('coverage_areas', [])) ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm text-gray-700">{{ $area->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('coverage_areas')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Method -->
                <div class="mb-6">
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                        Preferred Payment Method <span class="text-red-500">*</span>
                    </label>
                    <select id="payment_method" name="payment_method" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Select Payment Method --</option>
                        <option value="bKash" {{ old('payment_method') == 'bKash' ? 'selected' : '' }}>bKash</option>
                        <option value="Nagad" {{ old('payment_method') == 'Nagad' ? 'selected' : '' }}>Nagad</option>
                        <option value="Rocket" {{ old('payment_method') == 'Rocket' ? 'selected' : '' }}>Rocket</option>
                        <option value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    </select>
                    @error('payment_method')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Details -->
                <div class="mb-6">
                    <label for="payment_details" class="block text-sm font-medium text-gray-700 mb-2">
                        Payment Details <span class="text-red-500">*</span>
                    </label>
                    <textarea id="payment_details" name="payment_details" rows="4" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="For bKash/Nagad/Rocket: Enter mobile number&#10;For Bank Transfer: Enter bank name, account number, branch">{{ old('payment_details') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">This information will be used for commission payouts</p>
                    @error('payment_details')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Information Box -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h3 class="font-semibold text-blue-800 mb-2">Commission Information</h3>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Your unique referral code will be generated upon approval</li>
                        <li>• Earn commissions for every successful tuition placement</li>
                        <li>• Minimum payout amount: ৳1,000</li>
                        <li>• Platform fee: 10% on each commission payout</li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between pt-4 border-t">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Create Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
