@extends('layouts.app')

@section('title', 'Profile Rejected')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 to-pink-50 flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            <!-- Icon -->
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-gray-900 mb-4">Profile Not Approved</h2>
            <p class="text-lg text-gray-600 mb-8">
                Unfortunately, your profile could not be approved at this time. Please review the reason below and take necessary action.
            </p>

            <!-- Rejection Reason Box -->
            @if(auth()->user()->rejection_reason)
            <div class="bg-red-50 border-2 border-red-200 rounded-lg p-6 mb-8 text-left">
                <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Rejection Reason:
                </h3>
                <p class="text-gray-700">{{ auth()->user()->rejection_reason }}</p>
                <p class="text-sm text-gray-500 mt-3">
                    Rejected on {{ auth()->user()->rejected_at->format('F j, Y \a\t g:i A') }}
                </p>
            </div>
            @endif

            <!-- Next Steps -->
            <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6 mb-8">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-600 mr-3 mt-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <div class="text-left">
                        <h3 class="font-semibold text-gray-900 mb-2">What can you do?</h3>
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li>• Contact our support team for clarification</li>
                            <li>• Provide additional documents if requested</li>
                            <li>• Create a new account with correct information</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="mailto:support@findtutors.com?subject=Profile Rejection - {{ auth()->user()->email }}" 
                   class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Contact Support
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
