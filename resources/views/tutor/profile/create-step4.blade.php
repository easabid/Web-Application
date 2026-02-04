@extends('layouts.app')

@section('title', 'Create Profile - Step 4')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="relative">
                        <div class="overflow-hidden h-2 flex rounded bg-gray-200">
                            <div style="width:100%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-600 transition-all duration-500"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-2">
                <span class="text-sm text-gray-500">Step 1</span>
                <span class="text-sm text-gray-500">Step 2</span>
                <span class="text-sm text-gray-500">Step 3</span>
                <span class="text-sm font-medium text-indigo-600">Step 4</span>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Verification Documents</h2>
            <p class="text-gray-600 mb-6">Upload documents for identity verification (Upload at least one to submit)</p>

            <!-- Upload Document Form -->
            <form method="POST" action="{{ route('tutor.profile.store-document') }}" enctype="multipart/form-data" class="mb-8 p-6 bg-gray-50 rounded-lg">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Document Type -->
                    <div>
                        <label for="document_type" class="block text-sm font-medium text-gray-700 mb-2">Document Type *</label>
                        <select id="document_type" name="document_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                            <option value="">Select type</option>
                            <option value="NID">National ID (NID)</option>
                            <option value="Passport">Passport</option>
                            <option value="Birth Certificate">Birth Certificate</option>
                            <option value="Student ID">Student ID Card</option>
                            <option value="Educational Certificate">Educational Certificate</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Document File -->
                    <div>
                        <label for="document_file" class="block text-sm font-medium text-gray-700 mb-2">Upload File *</label>
                        <input type="file" id="document_file" name="document_file" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                        <p class="text-xs text-gray-500 mt-1">Max 5MB, PDF/JPG/PNG</p>
                    </div>
                </div>

                <button type="submit" class="mt-4 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    + Upload Document
                </button>
            </form>

            <!-- Uploaded Documents List -->
            <div class="mb-8">
                <h3 class="font-semibold text-gray-900 mb-4">Uploaded Documents ({{ $documents->count() }})</h3>
                @if($documents->isEmpty())
                    <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                        No documents uploaded yet. Please upload at least one verification document.
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($documents as $document)
                        <div class="border border-gray-200 rounded-lg p-4 flex justify-between items-center">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $document->document_type }}</h4>
                                    <p class="text-sm text-gray-500">Uploaded {{ $document->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('tutor.profile.delete-document', $document->id) }}" onsubmit="return confirm('Are you sure you want to delete this document?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between">
                <a href="{{ route('tutor.profile.create-step3') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition">
                    ← Previous
                </a>
                @if($documents->count() > 0)
                <form method="POST" action="{{ route('tutor.profile.submit') }}">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                        Submit Profile for Review
                    </button>
                </form>
                @else
                <button disabled class="bg-gray-300 text-gray-500 px-8 py-3 rounded-lg font-semibold cursor-not-allowed">
                    Submit Profile for Review
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
