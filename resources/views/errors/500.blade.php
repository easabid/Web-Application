@extends('layouts.app')

@section('title', '500 - Server Error')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-pink-50 flex items-center justify-center px-4">
    <div class="max-w-2xl w-full text-center">
        <!-- 500 Illustration -->
        <div class="mb-8">
            <svg class="w-64 h-64 mx-auto text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>

        <!-- Error Message -->
        <h1 class="text-9xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 mb-4">
            500
        </h1>
        <h2 class="text-4xl font-bold text-gray-800 mb-4">
            Oops! Something Went Wrong
        </h2>
        <p class="text-xl text-gray-600 mb-8">
            We're experiencing technical difficulties. Our team has been notified and is working to fix the issue.
        </p>

        <!-- Error Details Box -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8 text-left">
            <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                <svg class="w-6 h-6 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                What happened?
            </h3>
            <p class="text-gray-600 mb-4">
                An unexpected error occurred on our server while processing your request. This could be due to:
            </p>
            <ul class="space-y-2 text-gray-600">
                <li class="flex items-start gap-2">
                    <span class="text-purple-500 mt-1">•</span>
                    <span>A temporary server overload</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-purple-500 mt-1">•</span>
                    <span>A database connection issue</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-purple-500 mt-1">•</span>
                    <span>An unexpected configuration problem</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-purple-500 mt-1">•</span>
                    <span>Scheduled maintenance (rare)</span>
                </li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
            <button onclick="location.reload()" 
                class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-semibold flex items-center gap-2 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Refresh Page
            </button>
            
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
                        class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all font-semibold shadow-lg">
                        Go to Dashboard
                    </a>
                @elseif(auth()->user()->type == 3)
                    <a href="{{ route('tutor.dashboard') }}" 
                        class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all font-semibold shadow-lg">
                        Go to Dashboard
                    </a>
                @elseif(auth()->user()->type == 4)
                    <a href="{{ route('guardian.dashboard') }}" 
                        class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all font-semibold shadow-lg">
                        Go to Dashboard
                    </a>
                @elseif(auth()->user()->type == 5)
                    <a href="{{ route('partner.dashboard') }}" 
                        class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all font-semibold shadow-lg">
                        Go to Dashboard
                    </a>
                @endif
            @else
                <a href="{{ route('home') }}" 
                    class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all font-semibold shadow-lg">
                    Go to Home
                </a>
            @endauth
        </div>

        <!-- What to do next -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-bold text-yellow-800 mb-3 flex items-center justify-center gap-2">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                What should I do?
            </h3>
            <div class="text-left text-sm text-yellow-800 space-y-2">
                <p class="flex items-start gap-2">
                    <strong>1.</strong>
                    <span>Try refreshing the page using the button above</span>
                </p>
                <p class="flex items-start gap-2">
                    <strong>2.</strong>
                    <span>Wait a few minutes and try again</span>
                </p>
                <p class="flex items-start gap-2">
                    <strong>3.</strong>
                    <span>If the problem persists, contact our support team</span>
                </p>
                <p class="flex items-start gap-2">
                    <strong>4.</strong>
                    <span>Clear your browser cache and cookies</span>
                </p>
            </div>
        </div>

        <!-- Support Contact -->
        <div class="pt-8 border-t border-gray-200">
            <p class="text-gray-600 mb-4">Still experiencing issues?</p>
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow">
                <p class="text-sm text-gray-700 mb-3">
                    <strong>Contact Support:</strong>
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center text-sm">
                    <a href="mailto:support@tuitionmedia.com" class="text-blue-600 hover:text-blue-700 underline flex items-center gap-1 justify-center">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        support@tuitionmedia.com
                    </a>
                    <span class="text-gray-400 hidden sm:inline">•</span>
                    <a href="tel:+8801234567890" class="text-blue-600 hover:text-blue-700 underline flex items-center gap-1 justify-center">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                        +880 1234-567890
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
