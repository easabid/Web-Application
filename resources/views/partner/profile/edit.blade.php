@extends('layouts.app')

@section('title', 'Edit Partner Profile')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-3xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Edit Partner Profile</h2>
            <p class="text-gray-600 mb-6">Update your organization information</p>

            <form action="{{ route('partner.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Referral Code Display -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Referral Code</label>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-blue-600 tracking-wider">{{ $partner->referral_code }}</span>
                        <button type="button" onclick="copyReferralCode()" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                            Copy
                        </button>
                    </div>
                </div>

                <!-- Organization Name -->
                <div class="mb-6">
                    <label for="organization_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Organization Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="organization_name" name="organization_name" 
                        value="{{ $partner->organization_name }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('organization_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Coverage Areas -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Coverage Areas <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-64 overflow-y-auto border border-gray-200 rounded-lg p-4">
                        @foreach($areas as $area)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="coverage_areas[]" value="{{ $area->id }}"
                                    {{ in_array($area->id, $partner->coverage_areas) ? 'checked' : '' }}
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
                        Payment Method <span class="text-red-500">*</span>
                    </label>
                    <select id="payment_method" name="payment_method" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Select Payment Method --</option>
                        <option value="bKash" {{ $partner->payment_method == 'bKash' ? 'selected' : '' }}>bKash</option>
                        <option value="Nagad" {{ $partner->payment_method == 'Nagad' ? 'selected' : '' }}>Nagad</option>
                        <option value="Rocket" {{ $partner->payment_method == 'Rocket' ? 'selected' : '' }}>Rocket</option>
                        <option value="Bank Transfer" {{ $partner->payment_method == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
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
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $partner->payment_details }}</textarea>
                    @error('payment_details')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between pt-4 border-t">
                    <a href="{{ route('partner.dashboard') }}" class="text-gray-600 hover:text-gray-800">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function copyReferralCode() {
    const code = "{{ $partner->referral_code }}";
    navigator.clipboard.writeText(code).then(function() {
        alert('Referral code copied to clipboard!');
    });
}
</script>
@endsection
