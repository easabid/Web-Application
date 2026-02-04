@extends('layouts.app')

@section('title', 'Commission Approvals')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Commission Approvals</h1>
            <p class="text-gray-600 mt-1">Review and approve partner commission requests</p>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm">Pending Approval</p>
                <h3 class="text-3xl font-bold text-yellow-600 mt-1">{{ $stats['pending_count'] }}</h3>
                <p class="text-sm text-gray-600 mt-1">৳{{ number_format($stats['pending_amount'], 0) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm">Approved</p>
                <h3 class="text-3xl font-bold text-green-600 mt-1">{{ $stats['approved_count'] }}</h3>
                <p class="text-sm text-gray-600 mt-1">৳{{ number_format($stats['approved_amount'], 0) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm">Rejected</p>
                <h3 class="text-3xl font-bold text-red-600 mt-1">{{ $stats['rejected_count'] }}</h3>
                <p class="text-sm text-gray-600 mt-1">৳{{ number_format($stats['rejected_amount'], 0) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm">Total Paid</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['paid_count'] }}</h3>
                <p class="text-sm text-gray-600 mt-1">৳{{ number_format($stats['paid_amount'], 0) }}</p>
            </div>
        </div>

        <!-- Commissions List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($tuitions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Post Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Partner</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guardian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tutor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commission</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Confirmed</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tuitions as $tuition)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-mono text-sm font-medium text-blue-600">
                                            {{ $tuition->post->post_code }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $tuition->post->partner->user->full_name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $tuition->post->partner->organization_name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $tuition->guardian->user->full_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $tuition->tutor->user->full_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">
                                            ৳{{ number_format($tuition->commission_amount, 0) }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            Salary: ৳{{ number_format($tuition->monthly_salary, 0) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs text-gray-600">
                                            <div>Tutor: {{ $tuition->tutor_confirmed_at ? '✓' : '✗' }}</div>
                                            <div>Guardian: {{ $tuition->guardian_confirmed_at ? '✓' : '✗' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.commissions.show', $tuition->id) }}" 
                                            class="text-blue-600 hover:text-blue-900">
                                            Review
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $tuitions->links() }}
                </div>
            @else
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No pending commissions</h3>
                    <p class="mt-1 text-sm text-gray-500">All commission requests have been reviewed.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
