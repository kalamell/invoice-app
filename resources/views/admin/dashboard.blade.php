@extends('admin.layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')
@section('description', 'Overview of system statistics and activities')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Shops -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg transform hover:scale-105 transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Shops</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalShops) }}</h3>
                    <p class="text-sm text-gray-500 mt-2">
                        <span class="text-green-600 font-medium">{{ $activeShops }}</span> active
                    </p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg transform hover:scale-105 transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalUsers) }}</h3>
                    <p class="text-sm text-gray-500 mt-2">Registered accounts</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Subscriptions -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg transform hover:scale-105 transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active Subscriptions</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($activeSubscriptions) }}</h3>
                    <p class="text-sm text-gray-500 mt-2">
                        of {{ number_format($totalSubscriptions) }} total
                    </p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Revenue This Month -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg transform hover:scale-105 transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Revenue This Month</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">฿{{ number_format($revenueThisMonth, 2) }}</h3>
                    <p class="text-sm text-gray-500 mt-2">{{ now()->format('F Y') }}</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Shop Growth Chart -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                </svg>
                Shop Growth (Last 6 Months)
            </h3>
            <div class="space-y-3">
                @forelse($monthlyGrowth as $month)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">{{ \Carbon\Carbon::parse($month->month)->format('M Y') }}</span>
                            <span class="font-semibold text-gray-900">{{ $month->count }} shops</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-gradient-to-r from-blue-600 to-purple-600 h-2.5 rounded-full" style="width: {{ ($month->count / $totalShops) * 100 }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">No data available</p>
                @endforelse
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Revenue Trends (Last 6 Months)
            </h3>
            <div class="space-y-3">
                @php
                    $maxRevenue = $monthlyRevenue->max('revenue') ?: 1;
                @endphp
                @forelse($monthlyRevenue as $revenue)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">{{ \Carbon\Carbon::parse($revenue->month)->format('M Y') }}</span>
                            <span class="font-semibold text-gray-900">฿{{ number_format($revenue->revenue, 2) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-gradient-to-r from-green-500 to-teal-500 h-2.5 rounded-full" style="width: {{ ($revenue->revenue / $maxRevenue) * 100 }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">No data available</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Shops -->
    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Recent Shops
            </h3>
            <a href="{{ route('admin.shops.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                View all →
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                        <th class="pb-3">Shop Name</th>
                        <th class="pb-3">Owner</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3">Created</th>
                        <th class="pb-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentShops as $shop)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4">
                                <div class="font-medium text-gray-900">{{ $shop->name }}</div>
                                <div class="text-sm text-gray-500">{{ $shop->email }}</div>
                            </td>
                            <td class="py-4">
                                <div class="text-sm text-gray-900">{{ $shop->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $shop->user->email }}</div>
                            </td>
                            <td class="py-4">
                                @if($shop->is_active)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 text-sm text-gray-600">
                                {{ $shop->created_at->diffForHumans() }}
                            </td>
                            <td class="py-4">
                                <a href="{{ route('admin.shops.show', $shop) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    View →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">No shops registered yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-gray-700">Shop Status</h4>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Active</span>
                    <span class="font-bold text-green-600">{{ $activeShops }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Inactive</span>
                    <span class="font-bold text-red-600">{{ $inactiveShops }}</span>
                </div>
                <div class="pt-2 mt-2 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-gray-700">Total</span>
                        <span class="font-bold text-gray-900">{{ $totalShops }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-gray-700">Subscription Rate</h4>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    {{ $totalShops > 0 ? number_format(($totalSubscriptions / $totalShops) * 100, 1) : 0 }}%
                </div>
                <p class="text-sm text-gray-600 mt-2">of shops have subscriptions</p>
            </div>
        </div>

        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-gray-700">Active Rate</h4>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent">
                    {{ $totalShops > 0 ? number_format(($activeShops / $totalShops) * 100, 1) : 0 }}%
                </div>
                <p class="text-sm text-gray-600 mt-2">of shops are active</p>
            </div>
        </div>
    </div>
</div>
@endsection
