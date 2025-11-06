@extends('admin.layouts.admin')

@section('title', 'Subscriptions Management')
@section('header', 'Subscriptions Management')
@section('description', 'Manage all subscriptions in the system')

@section('content')
<div class="space-y-6">
    <!-- Search and Filter Bar -->
    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        <form method="GET" action="{{ route('admin.subscriptions.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="Search by shop or plan name..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                    <select name="sort" id="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                        <option value="start_date" {{ request('sort') == 'start_date' ? 'selected' : '' }}>Start Date</option>
                        <option value="end_date" {{ request('sort') == 'end_date' ? 'selected' : '' }}>End Date</option>
                        <option value="amount" {{ request('sort') == 'amount' ? 'selected' : '' }}>Amount</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:shadow-lg transform hover:scale-105 transition duration-300 font-semibold">
                    Apply Filters
                </button>
                <a href="{{ route('admin.subscriptions.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Subscriptions Table -->
    <div class="glass-effect rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr class="text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <th class="px-6 py-4">Shop</th>
                        <th class="px-6 py-4">Plan</th>
                        <th class="px-6 py-4">Amount</th>
                        <th class="px-6 py-4">Period</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($subscriptions as $subscription)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center text-white font-bold mr-3 shadow-md">
                                        {{ substr($subscription->shop->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $subscription->shop->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $subscription->shop->user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $subscription->plan->name }}</div>
                                <div class="text-xs text-gray-500">{{ $subscription->plan->duration_days }} days</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">฿{{ number_format($subscription->amount, 2) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $subscription->start_date->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">to {{ $subscription->end_date->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($subscription->status === 'active' && $subscription->end_date >= now())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                        Active
                                    </span>
                                @elseif($subscription->status === 'expired' || $subscription->end_date < now())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                                        Expired
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                        <span class="w-1.5 h-1.5 bg-gray-500 rounded-full mr-1.5"></span>
                                        {{ ucfirst($subscription->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.subscriptions.show', $subscription) }}" class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition text-sm font-medium">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                    <p class="text-gray-500 text-lg font-medium">No subscriptions found</p>
                                    <p class="text-gray-400 text-sm mt-1">Try adjusting your filters</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($subscriptions->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $subscriptions->links() }}
            </div>
        @endif
    </div>

    <!-- Summary -->
    <div class="glass-effect rounded-2xl p-4 shadow-lg">
        <div class="flex items-center justify-between text-sm text-gray-600">
            <span>Showing {{ $subscriptions->firstItem() ?? 0 }} to {{ $subscriptions->lastItem() ?? 0 }} of {{ $subscriptions->total() }} subscriptions</span>
            <span>{{ $subscriptions->currentPage() }} of {{ $subscriptions->lastPage() }} pages</span>
        </div>
    </div>
</div>
@endsection
