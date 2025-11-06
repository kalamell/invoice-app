@extends('admin.layouts.admin')

@section('title', 'User Details')
@section('header', $user->name)
@section('description', 'Detailed information about ' . $user->name)

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Users
        </a>
    </div>

    <!-- User Info Card -->
    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        <div class="flex items-start justify-between">
            <div class="flex items-start space-x-4">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-3xl shadow-lg">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-600 mt-1">{{ $user->email }}</p>
                    <div class="flex items-center space-x-4 mt-3">
                        @if($user->role === 'admin')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-purple-100 text-purple-800">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                                </svg>
                                Administrator
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                Shop Owner
                            </span>
                        @endif
                        @if($user->email_verified_at)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Email Verified
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                Not Verified
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Details & Shop Info -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- User Details -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                User Information
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Name</span>
                    <span class="font-semibold text-gray-900">{{ $user->name }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Email</span>
                    <span class="text-gray-900">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Role</span>
                    <span class="font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Email Verified</span>
                    @if($user->email_verified_at)
                        <span class="text-green-600 font-semibold">
                            Yes ({{ $user->email_verified_at->format('M d, Y') }})
                        </span>
                    @else
                        <span class="text-red-600 font-semibold">No</span>
                    @endif
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Joined</span>
                    <span class="text-gray-900">{{ $user->created_at->format('M d, Y H:i') }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Last Updated</span>
                    <span class="text-gray-900">{{ $user->updated_at->format('M d, Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Shop Information -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Shop Information
            </h3>
            @if($user->shop)
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-teal-500 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                            {{ substr($user->shop->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900 text-lg">{{ $user->shop->name }}</div>
                            <div class="text-sm text-gray-600">{{ $user->shop->email }}</div>
                        </div>
                    </div>

                    @if($user->shop->activeSubscription)
                        <div class="pt-3 border-t border-gray-200">
                            <div class="text-sm text-gray-600 mb-2">Active Subscription</div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $user->shop->activeSubscription->plan->name }}</div>
                                    <div class="text-xs text-gray-500">Until {{ $user->shop->activeSubscription->end_date->format('M d, Y') }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-green-600">฿{{ number_format($user->shop->activeSubscription->amount, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="pt-3 border-t border-gray-200">
                        <a href="{{ route('admin.shops.show', $user->shop) }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                            View Shop Details
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <p class="text-gray-500 font-medium">No Shop Registered</p>
                    <p class="text-gray-400 text-sm mt-1">This user hasn't created a shop yet</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Subscription History -->
    @if($user->shop && $user->shop->subscriptions->count() > 0)
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Subscription History
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                            <th class="pb-3">Plan</th>
                            <th class="pb-3">Amount</th>
                            <th class="pb-3">Start Date</th>
                            <th class="pb-3">End Date</th>
                            <th class="pb-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($user->shop->subscriptions as $subscription)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3 font-medium text-gray-900">{{ $subscription->plan->name }}</td>
                                <td class="py-3 text-gray-900">฿{{ number_format($subscription->amount, 2) }}</td>
                                <td class="py-3 text-sm text-gray-600">{{ $subscription->start_date->format('M d, Y') }}</td>
                                <td class="py-3 text-sm text-gray-600">{{ $subscription->end_date->format('M d, Y') }}</td>
                                <td class="py-3">
                                    @if($subscription->status === 'active')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @elseif($subscription->status === 'expired')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            Expired
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                            {{ ucfirst($subscription->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Role Management -->
    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
            </svg>
            Role Management
        </h3>
        <form method="POST" action="{{ route('admin.users.updateRole', $user) }}" class="max-w-md">
            @csrf
            @method('PATCH')
            <div class="space-y-4">
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Select Role</label>
                    <select name="role" id="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="shop_owner" {{ $user->role === 'shop_owner' ? 'selected' : '' }}>Shop Owner</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                </div>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                    <div class="flex">
                        <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-sm text-yellow-700">
                            <strong>Warning:</strong> Changing a user's role will affect their access permissions immediately.
                        </p>
                    </div>
                </div>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:shadow-lg transform hover:scale-105 transition duration-300 font-semibold">
                    Update Role
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
