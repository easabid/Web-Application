@extends('layouts.app')

@section('title', 'Create Profile - Step 3')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="relative">
                        <div class="overflow-hidden h-2 flex rounded bg-gray-200">
                            <div style="width:75%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-600 transition-all duration-500"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-2">
                <span class="text-sm text-gray-500">Step 1</span>
                <span class="text-sm text-gray-500">Step 2</span>
                <span class="text-sm font-medium text-indigo-600">Step 3</span>
                <span class="text-sm text-gray-500">Step 4</span>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Educational Qualifications</h2>
            <p class="text-gray-600 mb-6">Add your educational background (Add at least one to continue)</p>

            <!-- Add Qualification Form -->
            <form method="POST" action="{{ route('tutor.profile.store-qualification') }}" class="mb-8 p-6 bg-gray-50 rounded-lg">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Level -->
                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700 mb-2">Level *</label>
                        <select id="level" name="level" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                            <option value="">Select level</option>
                            <option value="SSC">SSC / O Level</option>
                            <option value="HSC">HSC / A Level</option>
                            <option value="Bachelors">Bachelors / Honors</option>
                            <option value="Masters">Masters / PhD</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <!-- Degree Title -->
                    <div>
                        <label for="degree_title" class="block text-sm font-medium text-gray-700 mb-2">Degree/Exam Title *</label>
                        <input type="text" id="degree_title" name="degree_title" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" placeholder="e.g., B.Sc. in CSE" required>
                    </div>

                    <!-- Institution -->
                    <div>
                        <label for="institution" class="block text-sm font-medium text-gray-700 mb-2">Institution *</label>
                        <input type="text" id="institution" name="institution" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" placeholder="e.g., Dhaka University" required>
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject/Group</label>
                        <input type="text" id="subject" name="subject" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" placeholder="e.g., Science, Computer Science">
                    </div>

                    <!-- Passing Year -->
                    <div>
                        <label for="passing_year" class="block text-sm font-medium text-gray-700 mb-2">Passing Year *</label>
                        <input type="number" id="passing_year" name="passing_year" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" min="1980" max="{{ date('Y') }}" placeholder="2020" required>
                    </div>

                    <!-- Result -->
                    <div>
                        <label for="result" class="block text-sm font-medium text-gray-700 mb-2">Result/GPA *</label>
                        <input type="text" id="result" name="result" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" placeholder="e.g., 5.00, A+, First Class" required>
                    </div>
                </div>

                <button type="submit" class="mt-4 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    + Add Qualification
                </button>
            </form>

            <!-- Added Qualifications List -->
            <div class="mb-8">
                <h3 class="font-semibold text-gray-900 mb-4">Added Qualifications ({{ $qualifications->count() }})</h3>
                @if($qualifications->isEmpty())
                    <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                        No qualifications added yet. Please add at least one to continue.
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($qualifications as $qualification)
                        <div class="border border-gray-200 rounded-lg p-4 flex justify-between items-start">
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $qualification->level }} - {{ $qualification->degree_title }}</h4>
                                <p class="text-sm text-gray-600">{{ $qualification->institution }}</p>
                                @if($qualification->subject)
                                <p class="text-sm text-gray-600">Subject: {{ $qualification->subject }}</p>
                                @endif
                                <p class="text-sm text-gray-600">Passing Year: {{ $qualification->passing_year }} | Result: {{ $qualification->result }}</p>
                            </div>
                            <form method="POST" action="{{ route('tutor.profile.delete-qualification', $qualification->id) }}" onsubmit="return confirm('Are you sure you want to delete this qualification?')">
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
                <a href="{{ route('tutor.profile.create-step2') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition">
                    ← Previous
                </a>
                @if($qualifications->count() > 0)
                <form method="POST" action="{{ route('tutor.profile.continue-step4') }}">
                    @csrf
                    <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Next: Upload Documents →
                    </button>
                </form>
                @else
                <button disabled class="bg-gray-300 text-gray-500 px-8 py-3 rounded-lg font-semibold cursor-not-allowed">
                    Next: Upload Documents →
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
