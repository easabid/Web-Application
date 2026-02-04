@extends('layouts.app')

@section('title', '404 - Page Not Found')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-purple-50 flex items-center justify-center px-4">
    <div class="max-w-2xl w-full text-center">
        <!-- 404 Illustration -->
        <div class="mb-8">
            <svg class="w-64 h-64 mx-auto text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <!-- Error Message -->
        <h1 class="text-9xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 mb-4">
            404
        </h1>
        <h2 class="text-4xl font-bold text-gray-800 mb-4">
            Oops! Page Not Found
        </h2>
        <p class="text-xl text-gray-600 mb-8">
            The page you're looking for doesn't exist or has been moved. Let's get you back on track!
        </p>

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
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all font-semibold shadow-lg">
                        Go to Dashboard
                    </a>
                @elseif(auth()->user()->type == 3)
                    <a href="{{ route('tutor.dashboard') }}" 
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all font-semibold shadow-lg">
                        Go to Dashboard
                    </a>
                @elseif(auth()->user()->type == 4)
                    <a href="{{ route('guardian.dashboard') }}" 
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all font-semibold shadow-lg">
                        Go to Dashboard
                    </a>
                @elseif(auth()->user()->type == 5)
                    <a href="{{ route('partner.dashboard') }}" 
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all font-semibold shadow-lg">
                        Go to Dashboard
                    </a>
                @endif
            @else
                <a href="{{ route('home') }}" 
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all font-semibold shadow-lg">
                    Go to Home
                </a>
            @endauth
        </div>

        <!-- Helpful Links -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <p class="text-gray-600 mb-4">Need help? Try these pages:</p>
            <div class="flex flex-wrap gap-4 justify-center">
                @auth
                    @if(auth()->user()->type == 3)
                        <a href="{{ route('tutor.posts.index') }}" class="text-blue-600 hover:text-blue-700 underline">
                            Browse Tuition Posts
                        </a>
                        <a href="{{ route('tutor.applications.index') }}" class="text-blue-600 hover:text-blue-700 underline">
                            My Applications
                        </a>
                    @elseif(auth()->user()->type == 4)
                        <a href="{{ route('guardian.posts.create') }}" class="text-blue-600 hover:text-blue-700 underline">
                            Create Post
                        </a>
                        <a href="{{ route('guardian.posts.index') }}" class="text-blue-600 hover:text-blue-700 underline">
                            My Posts
                        </a>
                    @elseif(auth()->user()->type == 5)
                        <a href="{{ route('partner.posts.create') }}" class="text-blue-600 hover:text-blue-700 underline">
                            Create Commission Post
                        </a>
                        <a href="{{ route('partner.earnings.index') }}" class="text-blue-600 hover:text-blue-700 underline">
                            My Earnings
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 underline">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 underline">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
