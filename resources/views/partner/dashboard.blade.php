@extends('layouts.app')

@section('title', 'Partner Dashboard')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Partner Dashboard</h1>
            <p class="text-gray-600 mt-1">Manage your tuition posts and track your earnings</p>
        </div>

        <!-- Referral Code Card -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm mb-1">Your Referral Code</p>
                    <h2 class="text-white text-3xl font-bold tracking-wider">{{ $partner->referral_code }}</h2>
                </div>
                <div class="text-right">
                    <p class="text-blue-100 text-sm">Share this code to earn commissions</p>
                    <button onclick="copyReferralCode()" 
                        class="mt-2 px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-blue-50 transition-colors text-sm font-medium">
                        Copy Code
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Posts -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Posts</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total_posts'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Active Posts -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Active Posts</p>
                        <h3 class="text-3xl font-bold text-green-600 mt-1">{{ $stats['active_posts'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Confirmed Tuitions -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Confirmed Tuitions</p>
                        <h3 class="text-3xl font-bold text-purple-600 mt-1">{{ $stats['confirmed_tuitions'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Lifetime Earnings -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Lifetime Earnings</p>
                        <h3 class="text-3xl font-bold text-orange-600 mt-1">৳{{ number_format($earnings['lifetime_earnings'], 0) }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings Breakdown -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                <p class="text-gray-600 text-sm mb-1">Pending Payout</p>
                <h3 class="text-2xl font-bold text-gray-800">৳{{ number_format($earnings['pending_payout'], 0) }}</h3>
                <p class="text-xs text-gray-500 mt-2">Available for withdrawal</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <p class="text-gray-600 text-sm mb-1">Total Earnings</p>
                <h3 class="text-2xl font-bold text-gray-800">৳{{ number_format($earnings['total_earnings'], 0) }}</h3>
                <p class="text-xs text-gray-500 mt-2">All approved commissions</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <p class="text-gray-600 text-sm mb-1">Total Paid</p>
                <h3 class="text-2xl font-bold text-gray-800">৳{{ number_format($earnings['total_paid'], 0) }}</h3>
                <p class="text-xs text-gray-500 mt-2">Successfully withdrawn</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a href="{{ route('partner.posts.create') }}" 
                class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow p-6 transition-colors group">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-lg">Post New Tuition</h4>
                        <p class="text-blue-100 text-sm mt-1">Create commission post</p>
                    </div>
                    <svg class="w-8 h-8 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
            </a>

            <a href="{{ route('partner.earnings.index') }}" 
                class="bg-green-600 hover:bg-green-700 text-white rounded-lg shadow p-6 transition-colors group">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-lg">View Earnings</h4>
                        <p class="text-green-100 text-sm mt-1">Track commissions</p>
                    </div>
                    <svg class="w-8 h-8 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <a href="{{ route('partner.payouts.create') }}" 
                class="bg-purple-600 hover:bg-purple-700 text-white rounded-lg shadow p-6 transition-colors group">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-lg">Request Payout</h4>
                        <p class="text-purple-100 text-sm mt-1">Withdraw earnings</p>
                    </div>
                    <svg class="w-8 h-8 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
        </div>

        <!-- Recent Commissions -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-800">Recent Commissions</h3>
            </div>
            <div class="overflow-x-auto">
                @if($recentCommissions->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Post Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guardian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tutor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commission</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentCommissions as $tuition)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-mono text-sm font-medium text-blue-600">
                                            {{ $tuition->post->post_code }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $tuition->guardian->user->full_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $tuition->tutor->user->full_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        ৳{{ number_format($tuition->commission_amount, 0) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($tuition->commission_status == 'Approved')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Approved
                                            </span>
                                        @elseif($tuition->commission_status == 'Pending')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($tuition->commission_status == 'Paid')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Paid
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $tuition->created_at->format('d M Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-8 text-center">
                        <p class="text-gray-500">No commission records yet.</p>
                        <a href="{{ route('partner.posts.create') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">
                            Create your first post
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function copyReferralCode() {
    const code = "{{ $partner->referral_code }}";
    navigator.clipboard.writeText(code).then(function() {
        alert('Referral code copied to clipboard!');
    });
}
</script>
@endsection
