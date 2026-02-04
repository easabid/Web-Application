@extends('layouts.app')

@section('title', 'Complete Tuition')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Back Button -->
        <a href="{{ route('guardian.tuitions.show', $tuition->id) }}" class="text-blue-600 hover:text-blue-700 flex items-center gap-2 mb-6">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Tuition
        </a>

        <!-- Header -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Mark Tuition as Completed</h1>
            <p class="text-gray-600 mt-2">{{ $tuition->post->post_code }} • {{ $tuition->tutor->user->full_name }}</p>
        </div>

        <!-- Confirmation Form -->
        <form action="{{ route('guardian.tuitions.complete', $tuition->id) }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf

            <!-- End Date -->
            <div class="mb-6">
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                    End Date <span class="text-red-500">*</span>
                </label>
                <input type="date" name="end_date" id="end_date" 
                    value="{{ old('end_date', now()->format('Y-m-d')) }}" required
                    min="{{ $tuition->start_date->format('Y-m-d') }}"
                    max="{{ now()->format('Y-m-d') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('end_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Tuition started on {{ $tuition->start_date->format('d M Y') }}</p>
            </div>

            <!-- Confirmation Checkbox -->
            <div class="mb-6">
                <label class="flex items-start">
                    <input type="checkbox" name="confirm_completion" value="1" required
                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-1">
                    <span class="ml-3 text-sm text-gray-700">
                        I confirm that this tuition has been completed. The tutor has fulfilled their teaching duties satisfactorily, and all payments have been settled.
                    </span>
                </label>
                @error('confirm_completion')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Summary -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="font-bold text-blue-800 mb-3">Tuition Summary</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-blue-700">Tutor:</span>
                        <span class="font-semibold text-blue-900">{{ $tuition->tutor->user->full_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-700">Class:</span>
                        <span class="font-semibold text-blue-900">{{ $tuition->post->classLevel->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-700">Monthly Salary:</span>
                        <span class="font-semibold text-blue-900">৳{{ number_format($tuition->monthly_salary) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-700">Start Date:</span>
                        <span class="font-semibold text-blue-900">{{ $tuition->start_date->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Info Alert -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="font-semibold text-yellow-800 mb-1">Important Note</p>
                        <p class="text-sm text-yellow-700">
                            After marking as completed, you'll be able to write a review for the tutor. This action cannot be undone.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit" 
                    class="flex-1 px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium">
                    Complete Tuition
                </button>
                <a href="{{ route('guardian.tuitions.show', $tuition->id) }}" 
                    class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
