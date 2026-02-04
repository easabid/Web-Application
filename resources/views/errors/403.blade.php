@extends('layouts.app')

@section('title', '403 - Access Forbidden')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 to-orange-50 flex items-center justify-center px-4">
    <div class="max-w-2xl w-full text-center">
        <!-- 403 Illustration -->
        <div class="mb-8">
            <svg class="w-64 h-64 mx-auto text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>

        <!-- Error Message -->
        <h1 class="text-9xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-orange-600 mb-4">
            403
        </h1>
        <h2 class="text-4xl font-bold text-gray-800 mb-4">
            Access Forbidden
        </h2>
        <p class="text-xl text-gray-600 mb-8">
            You don't have permission to access this page. This area is restricted to authorized users only.
        </p>

        <!-- Explanation Box -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8 text-left">
            <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                <svg class="w-6 h-6 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                Why am I seeing this?
            </h3>
            <ul class="space-y-2 text-gray-600">
                <li class="flex items-start gap-2">
                    <span class="text-orange-500 mt-1">•</span>
                    <span>You're trying to access a page that requires special permissions</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-orange-500 mt-1">•</span>
                    <span>This page might be for a different user role (Admin, Tutor, Guardian, Partner)</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-orange-500 mt-1">•</span>
                    <span>Your account might not have completed the required profile steps</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-orange-500 mt-1">•</span>
                    <span>Your account may be awaiting admin approval</span>
                </li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ url()->previous() }}" 
                class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Go Back
            </a>
            
            @auth
                @if(auth()->user()->type == 1 || auth()->user()->type == 2)
                    <a href="{{ route('admin.dashboard') }}" 
                        class="px-6 py-3 bg-gradient-to-r from-red-600 to-orange-600 text-white rounded-lg hover:from-red-700 hover:to-orange-700 transition-all font-semibold shadow-lg">
                        Go to Dashboard
                    </a>
                @elseif(auth()->user()->type == 3)
                    <a href="{{ route('tutor.dashboard') }}" 
                        class="px-6 py-3 bg-gradient-to-r from-red-600 to-orange-600 text-white rounded-lg hover:from-red-700 hover:to-orange-700 transition-all font-semibold shadow-lg">
                        Go to Dashboard
                    </a>
                @elseif(auth()->user()->type == 4)
                    <a href="{{ route('guardian.dashboard') }}" 
                        class="px-6 py-3 bg-gradient-to-r from-red-600 to-orange-600 text-white rounded-lg hover:from-red-700 hover:to-orange-700 transition-all font-semibold shadow-lg">
                        Go to Dashboard
                    </a>
                @elseif(auth()->user()->type == 5)
                    <a href="{{ route('partner.dashboard') }}" 
                        class="px-6 py-3 bg-gradient-to-r from-red-600 to-orange-600 text-white rounded-lg hover:from-red-700 hover:to-orange-700 transition-all font-semibold shadow-lg">
                        Go to Dashboard
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" 
                    class="px-6 py-3 bg-gradient-to-r from-red-600 to-orange-600 text-white rounded-lg hover:from-red-700 hover:to-orange-700 transition-all font-semibold shadow-lg">
                    Login to Continue
                </a>
            @endauth
        </div>

        <!-- Help Section -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <p class="text-gray-600 mb-4">Need access to this page?</p>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-blue-800">
                    💡 <strong>Tip:</strong> Make sure you're logged in with the correct account type. 
                    If you believe you should have access, please contact support or check your account status.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
