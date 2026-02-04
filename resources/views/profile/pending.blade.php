@extends('layouts.app')

@section('title', 'Profile Pending Approval')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-orange-50 flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            <!-- Icon -->
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-gray-900 mb-4">Profile Under Review</h2>
            <p class="text-lg text-gray-600 mb-8">
                Thank you for completing your profile! Our admin team is currently reviewing your information. This usually takes 24-48 hours.
            </p>

            <!-- Status Box -->
            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-lg p-6 mb-8">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-yellow-600 mr-3 mt-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <div class="text-left">
                        <h3 class="font-semibold text-gray-900 mb-2">What happens next?</h3>
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li>✓ Our team will verify your information and documents</li>
                            <li>✓ You'll receive an email notification once approved</li>
                            <li>✓ After approval, you can access all platform features</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Logout
                    </button>
                </form>
                <a href="mailto:support@findtutors.com" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Contact Support
                </a>
            </div>

            <p class="mt-8 text-sm text-gray-500">
                Submitted on {{ auth()->user()->created_at->format('F j, Y \a\t g:i A') }}
            </p>
        </div>
    </div>
</div>
@endsection
