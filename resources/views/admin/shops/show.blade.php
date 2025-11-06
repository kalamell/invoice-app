@extends('admin.layouts.admin')

@section('title', 'Shop Details')
@section('header', $shop->name)
@section('description', 'Detailed information about ' . $shop->name)

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.shops.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Shops
        </a>
    </div>

    <!-- Shop Info Card -->
    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        <div class="flex items-start justify-between">
            <div class="flex items-start space-x-4">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-500 rounded-2xl flex items-center justify-center text-white font-bold text-3xl shadow-lg">
                    {{ substr($shop->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $shop->name }}</h2>
                    <p class="text-gray-600 mt-1">{{ $shop->description }}</p>
                    <div class="flex items-center space-x-4 mt-3">
                        <span class="text-sm text-gray-600">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ $shop->email }}
                        </span>
                        @if($shop->phone)
                            <span class="text-sm text-gray-600">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ $shop->phone }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                @if($shop->is_active)
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        Active
                    </span>
                @else
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                        <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                        Suspended
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <div class="text-sm font-medium text-gray-600 mb-2">Customers</div>
            <div class="text-3xl font-bold text-blue-600">{{ number_format($stats['total_customers']) }}</div>
        </div>
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <div class="text-sm font-medium text-gray-600 mb-2">Quotations</div>
            <div class="text-3xl font-bold text-purple-600">{{ number_format($stats['total_quotations']) }}</div>
        </div>
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <div class="text-sm font-medium text-gray-600 mb-2">Invoices</div>
            <div class="text-3xl font-bold text-green-600">{{ number_format($stats['total_invoices']) }}</div>
        </div>
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <div class="text-sm font-medium text-gray-600 mb-2">Receipts</div>
            <div class="text-3xl font-bold text-pink-600">{{ number_format($stats['total_receipts']) }}</div>
        </div>
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <div class="text-sm font-medium text-gray-600 mb-2">Total Revenue</div>
            <div class="text-2xl font-bold text-teal-600">฿{{ number_format($stats['total_revenue'], 2) }}</div>
        </div>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Shop Details -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Shop Information
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Shop Name</span>
                    <span class="font-semibold text-gray-900">{{ $shop->name }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Slug</span>
                    <span class="font-mono text-sm text-gray-900">{{ $shop->slug }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Email</span>
                    <span class="text-gray-900">{{ $shop->email }}</span>
                </div>
                @if($shop->phone)
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Phone</span>
                        <span class="text-gray-900">{{ $shop->phone }}</span>
                    </div>
                @endif
                @if($shop->tax_id)
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Tax ID</span>
                        <span class="text-gray-900">{{ $shop->tax_id }}</span>
                    </div>
                @endif
                @if($shop->website)
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Website</span>
                        <a href="{{ $shop->website }}" target="_blank" class="text-blue-600 hover:text-blue-700">{{ $shop->website }}</a>
                    </div>
                @endif
                @if($shop->address)
                    <div class="py-2 border-b border-gray-100">
                        <span class="text-gray-600 block mb-1">Address</span>
                        <span class="text-gray-900">{{ $shop->address }}</span>
                    </div>
                @endif
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Created At</span>
                    <span class="text-gray-900">{{ $shop->created_at->format('M d, Y H:i') }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Last Updated</span>
                    <span class="text-gray-900">{{ $shop->updated_at->format('M d, Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Owner Details -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Owner Information
            </h3>
            <div class="space-y-4">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                        {{ substr($shop->user->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 text-lg">{{ $shop->user->name }}</div>
                        <div class="text-gray-600">{{ $shop->user->email }}</div>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                {{ ucfirst(str_replace('_', ' ', $shop->user->role)) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.users.show', $shop->user) }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                        View User Profile
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Subscription -->
    @if($shop->activeSubscription)
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Active Subscription
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <div class="text-sm text-gray-600 mb-1">Plan</div>
                    <div class="font-semibold text-gray-900">{{ $shop->activeSubscription->plan->name }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-600 mb-1">Amount</div>
                    <div class="font-semibold text-gray-900">฿{{ number_format($shop->activeSubscription->amount, 2) }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-600 mb-1">Start Date</div>
                    <div class="font-semibold text-gray-900">{{ $shop->activeSubscription->start_date->format('M d, Y') }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-600 mb-1">End Date</div>
                    <div class="font-semibold text-gray-900">{{ $shop->activeSubscription->end_date->format('M d, Y') }}</div>
                </div>
            </div>
        </div>
    @else
        <div class="glass-effect rounded-2xl p-6 shadow-lg border-2 border-dashed border-gray-300">
            <div class="text-center py-8">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-gray-600 font-medium">No Active Subscription</p>
                <p class="text-gray-500 text-sm mt-1">This shop doesn't have an active subscription plan</p>
            </div>
        </div>
    @endif

    <!-- Recent Subscriptions -->
    @if($shop->subscriptions->count() > 0)
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Recent Subscriptions
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                            <th class="pb-3">Plan</th>
                            <th class="pb-3">Amount</th>
                            <th class="pb-3">Period</th>
                            <th class="pb-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($shop->subscriptions as $subscription)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3 font-medium text-gray-900">{{ $subscription->plan->name }}</td>
                                <td class="py-3 text-gray-900">฿{{ number_format($subscription->amount, 2) }}</td>
                                <td class="py-3 text-sm text-gray-600">
                                    {{ $subscription->start_date->format('M d, Y') }} - {{ $subscription->end_date->format('M d, Y') }}
                                </td>
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

    <!-- Actions -->
    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Actions</h3>
        <div class="flex flex-wrap gap-3">
            <form method="POST" action="{{ route('admin.shops.suspend', $shop) }}" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-6 py-3 {{ $shop->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-lg font-semibold shadow-lg hover:shadow-xl transition duration-300">
                    {{ $shop->is_active ? 'Suspend Shop' : 'Activate Shop' }}
                </button>
            </form>
            <form method="POST" action="{{ route('admin.shops.destroy', $shop) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this shop? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold shadow-lg hover:shadow-xl transition duration-300">
                    Delete Shop
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
