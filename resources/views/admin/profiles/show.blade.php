@extends('layouts.app')

@section('title', 'Review Profile')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-5xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Review Profile</h1>
                <p class="text-gray-600 mt-1">Review and approve or reject this profile</p>
            </div>
            <a href="{{ route('admin.profiles.index') }}" class="text-blue-600 hover:text-blue-700">
                ← Back to List
            </a>
        </div>

        <!-- User Information Card -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">User Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Full Name</p>
                    <p class="font-semibold text-gray-900">{{ $user->full_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">User Type</p>
                    <p class="font-semibold text-gray-900">{{ getUserType($user->type) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-semibold text-gray-900">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Mobile</p>
                    <p class="font-semibold text-gray-900">{{ $user->mobile }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email Verified</p>
                    <p class="font-semibold {{ $user->email_verified_at ? 'text-green-600' : 'text-red-600' }}">
                        {{ $user->email_verified_at ? 'Yes' : 'No' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Profile Submitted</p>
                    <p class="font-semibold text-gray-900">
                        {{ $user->profile_completed_at ? $user->profile_completed_at->format('d M Y, h:i A') : 'Not Submitted' }}
                    </p>
                </div>
            </div>
        </div>

        @if($user->type == 3 && $user->tutor)
            <!-- Tutor Profile -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Tutor Profile</h2>

                <!-- Photo -->
                @if($user->tutor->photo)
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 mb-2">Profile Photo</p>
                        <img src="{{ asset('storage/' . $user->tutor->photo) }}" 
                            alt="Profile Photo" class="w-32 h-32 rounded-full object-cover">
                    </div>
                @endif

                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Gender</p>
                        <p class="font-semibold text-gray-900">{{ $user->tutor->gender }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Date of Birth</p>
                        <p class="font-semibold text-gray-900">{{ $user->tutor->date_of_birth->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Area</p>
                        <p class="font-semibold text-gray-900">{{ $user->tutor->area->name }} ({{ $user->tutor->area->division }})</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Salary Range</p>
                        <p class="font-semibold text-gray-900">৳{{ number_format($user->tutor->expected_minimum_salary) }} - ৳{{ number_format($user->tutor->expected_maximum_salary) }}</p>
                    </div>
                </div>

                <!-- Address -->
                <div class="mb-6">
                    <p class="text-sm text-gray-500">Address</p>
                    <p class="font-semibold text-gray-900">{{ $user->tutor->address }}</p>
                </div>

                <!-- Bio -->
                @if($user->tutor->bio)
                    <div class="mb-6">
                        <p class="text-sm text-gray-500">Bio</p>
                        <p class="text-gray-900">{{ $user->tutor->bio }}</p>
                    </div>
                @endif

                <!-- Subjects -->
                <div class="mb-6">
                    <p class="text-sm text-gray-500 mb-2">Subjects</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->tutor->subjects as $subjectId)
                            @php
                                $subject = \App\Models\Subject::find($subjectId);
                            @endphp
                            @if($subject)
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                    {{ $subject->name }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Class Levels -->
                <div class="mb-6">
                    <p class="text-sm text-gray-500 mb-2">Class Levels</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->tutor->class_levels as $classId)
                            @php
                                $class = \App\Models\ClassLevel::find($classId);
                            @endphp
                            @if($class)
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                    {{ $class->name }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Qualifications -->
                @if($user->tutor->qualifications->count() > 0)
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 mb-3">Educational Qualifications</p>
                        <div class="space-y-3">
                            @foreach($user->tutor->qualifications as $qualification)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h4 class="font-semibold text-gray-900">{{ $qualification->degree }}</h4>
                                    <p class="text-gray-700">{{ $qualification->institution }}</p>
                                    <p class="text-sm text-gray-500">{{ $qualification->field_of_study }} | {{ $qualification->year }}</p>
                                    @if($qualification->result)
                                        <p class="text-sm text-gray-600 mt-1">Result: {{ $qualification->result }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Documents -->
                @if($user->tutor->documents->count() > 0)
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 mb-3">Uploaded Documents</p>
                        <div class="space-y-2">
                            @foreach($user->tutor->documents as $document)
                                <div class="flex items-center justify-between border border-gray-200 rounded-lg p-3">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $document->document_type }}</p>
                                        <p class="text-sm text-gray-500">{{ $document->document_name }}</p>
                                    </div>
                                    <a href="{{ asset('storage/' . $document->document_path) }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                        View
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        @elseif($user->type == 4 && $user->guardian)
            <!-- Guardian Profile -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Guardian Profile</h2>

                <!-- Photo -->
                @if($user->guardian->photo)
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 mb-2">Profile Photo</p>
                        <img src="{{ asset('storage/' . $user->guardian->photo) }}" 
                            alt="Profile Photo" class="w-32 h-32 rounded-full object-cover">
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Relation to Student</p>
                        <p class="font-semibold text-gray-900">{{ $user->guardian->relation_to_student }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Area</p>
                        <p class="font-semibold text-gray-900">{{ $user->guardian->area->name }} ({{ $user->guardian->area->division }})</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="font-semibold text-gray-900">{{ $user->guardian->address }}</p>
                    </div>
                </div>
            </div>

        @elseif($user->type == 5 && $user->partner)
            <!-- Partner Profile -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Tuition Partner Profile</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Organization Name</p>
                        <p class="font-semibold text-gray-900">{{ $user->partner->organization_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Payment Method</p>
                        <p class="font-semibold text-gray-900">{{ $user->partner->payment_method }}</p>
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="mb-6">
                    <p class="text-sm text-gray-500">Payment Details</p>
                    <p class="font-semibold text-gray-900">{{ $user->partner->payment_details }}</p>
                </div>

                <!-- Coverage Areas -->
                <div class="mb-6">
                    <p class="text-sm text-gray-500 mb-2">Coverage Areas</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->partner->coverage_areas as $areaId)
                            @php
                                $area = \App\Models\Area::find($areaId);
                            @endphp
                            @if($area)
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm">
                                    {{ $area->name }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Approval/Rejection Form -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Approve -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold text-green-700 mb-4">Approve Profile</h3>
                <p class="text-gray-600 mb-4">This user will be able to access their dashboard and use the platform.</p>
                <form action="{{ route('admin.profiles.approve', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit" 
                        class="w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold">
                        Approve Profile
                    </button>
                </form>
            </div>

            <!-- Reject -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold text-red-700 mb-4">Reject Profile</h3>
                <form action="{{ route('admin.profiles.reject', $user->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Rejection Reason <span class="text-red-500">*</span>
                        </label>
                        <textarea id="rejection_reason" name="rejection_reason" rows="3" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            placeholder="Provide a reason for rejection (minimum 10 characters)"></textarea>
                    </div>
                    <button type="submit" 
                        class="w-full px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold">
                        Reject Profile
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
