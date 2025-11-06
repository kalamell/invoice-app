@extends('admin.layouts.admin')

@section('title', 'Subscription Details')
@section('header', 'Subscription Details')
@section('description', 'Detailed information about subscription #' . $subscription->id)

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.subscriptions.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Subscriptions
        </a>
    </div>

    <!-- Subscription Status Card -->
    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Subscription #{{ $subscription->id }}</h2>
                <p class="text-gray-600 mt-1">Created on {{ $subscription->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div>
                @if($subscription->status === 'active' && $subscription->end_date >= now())
                    <span class="inline-flex items-center px-6 py-3 rounded-full text-base font-semibold bg-green-100 text-green-800 shadow-md">
                        <span class="w-2.5 h-2.5 bg-green-500 rounded-full mr-2"></span>
                        Active
                    </span>
                @elseif($subscription->status === 'expired' || $subscription->end_date < now())
                    <span class="inline-flex items-center px-6 py-3 rounded-full text-base font-semibold bg-red-100 text-red-800 shadow-md">
                        <span class="w-2.5 h-2.5 bg-red-500 rounded-full mr-2"></span>
                        Expired
                    </span>
                @else
                    <span class="inline-flex items-center px-6 py-3 rounded-full text-base font-semibold bg-gray-100 text-gray-800 shadow-md">
                        <span class="w-2.5 h-2.5 bg-gray-500 rounded-full mr-2"></span>
                        {{ ucfirst($subscription->status) }}
                    </span>
                @endif
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="text-sm text-gray-600 mb-2">Amount Paid</div>
                <div class="text-3xl font-bold text-green-600">฿{{ number_format($subscription->amount, 2) }}</div>
            </div>
            <div class="text-center">
                <div class="text-sm text-gray-600 mb-2">Start Date</div>
                <div class="text-xl font-bold text-gray-900">{{ $subscription->start_date->format('M d, Y') }}</div>
            </div>
            <div class="text-center">
                <div class="text-sm text-gray-600 mb-2">End Date</div>
                <div class="text-xl font-bold text-gray-900">{{ $subscription->end_date->format('M d, Y') }}</div>
            </div>
            <div class="text-center">
                <div class="text-sm text-gray-600 mb-2">Days Remaining</div>
                @php
                    $daysRemaining = max(0, now()->diffInDays($subscription->end_date, false));
                @endphp
                <div class="text-3xl font-bold {{ $daysRemaining > 7 ? 'text-blue-600' : 'text-red-600' }}">
                    {{ $daysRemaining > 0 ? $daysRemaining : 0 }}
                </div>
            </div>
        </div>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Plan Information -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Plan Information
            </h3>
            <div class="space-y-4">
                <div class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-gray-900 mb-1">{{ $subscription->plan->name }}</div>
                    @if($subscription->plan->description)
                        <div class="text-sm text-gray-600">{{ $subscription->plan->description }}</div>
                    @endif
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Plan Price</span>
                        <span class="font-semibold text-gray-900">฿{{ number_format($subscription->plan->price, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Duration</span>
                        <span class="font-semibold text-gray-900">{{ $subscription->plan->duration_days }} days</span>
                    </div>
                    @if($subscription->plan->max_documents)
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Max Documents</span>
                            <span class="font-semibold text-gray-900">{{ number_format($subscription->plan->max_documents) }}</span>
                        </div>
                    @endif
                    @if($subscription->plan->max_customers)
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Max Customers</span>
                            <span class="font-semibold text-gray-900">{{ number_format($subscription->plan->max_customers) }}</span>
                        </div>
                    @endif
                </div>

                <div class="pt-3 border-t border-gray-200">
                    <div class="text-sm font-medium text-gray-700 mb-3">Features:</div>
                    <div class="space-y-2">
                        <div class="flex items-center text-sm">
                            @if($subscription->plan->can_send_line)
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">Can send via LINE</span>
                            @else
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-400">Cannot send via LINE</span>
                            @endif
                        </div>
                        <div class="flex items-center text-sm">
                            @if($subscription->plan->can_customize_template)
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">Can customize templates</span>
                            @else
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-400">Cannot customize templates</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shop Information -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Shop Information
            </h3>
            <div class="space-y-4">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-teal-500 rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                        {{ substr($subscription->shop->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 text-xl">{{ $subscription->shop->name }}</div>
                        <div class="text-sm text-gray-600">{{ $subscription->shop->email }}</div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200 space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Shop Status</span>
                        @if($subscription->shop->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                Suspended
                            </span>
                        @endif
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Owner</span>
                        <span class="font-semibold text-gray-900">{{ $subscription->shop->user->name }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Owner Email</span>
                        <span class="text-gray-900">{{ $subscription->shop->user->email }}</span>
                    </div>
                    @if($subscription->shop->phone)
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Phone</span>
                            <span class="text-gray-900">{{ $subscription->shop->phone }}</span>
                        </div>
                    @endif
                </div>

                <div class="pt-3 border-t border-gray-200">
                    <a href="{{ route('admin.shops.show', $subscription->shop) }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                        View Shop Details
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscription Details -->
    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Subscription Details
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Subscription ID</span>
                    <span class="font-mono font-semibold text-gray-900">#{{ $subscription->id }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Status</span>
                    <span class="font-semibold text-gray-900">{{ ucfirst($subscription->status) }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Amount Paid</span>
                    <span class="font-bold text-green-600">฿{{ number_format($subscription->amount, 2) }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Created At</span>
                    <span class="text-gray-900">{{ $subscription->created_at->format('M d, Y H:i') }}</span>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Start Date</span>
                    <span class="font-semibold text-gray-900">{{ $subscription->start_date->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">End Date</span>
                    <span class="font-semibold text-gray-900">{{ $subscription->end_date->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Duration</span>
                    <span class="text-gray-900">{{ $subscription->start_date->diffInDays($subscription->end_date) }} days</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Last Updated</span>
                    <span class="text-gray-900">{{ $subscription->updated_at->format('M d, Y H:i') }}</span>
                </div>
            </div>
        </div>

        @if($subscription->notes)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="text-sm font-medium text-gray-700 mb-2">Notes:</div>
                <div class="bg-gray-50 rounded-lg p-4 text-gray-700">
                    {{ $subscription->notes }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
