@extends('admin.layouts.admin')

@section('title', 'Shops Management')
@section('header', 'Shops Management')
@section('description', 'Manage all shops in the system')

@section('content')
<div class="space-y-6">
    <!-- Search and Filter Bar -->
    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        <form method="GET" action="{{ route('admin.shops.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="Search by shop name, email, or owner..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                    <select name="sort" id="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                        <option value="updated_at" {{ request('sort') == 'updated_at' ? 'selected' : '' }}>Last Updated</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:shadow-lg transform hover:scale-105 transition duration-300 font-semibold">
                    Apply Filters
                </button>
                <a href="{{ route('admin.shops.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Shops Table -->
    <div class="glass-effect rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr class="text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <th class="px-6 py-4">Shop Details</th>
                        <th class="px-6 py-4">Owner</th>
                        <th class="px-6 py-4">Subscription</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Created</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($shops as $shop)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center text-white font-bold text-lg mr-3 shadow-md">
                                        {{ substr($shop->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $shop->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $shop->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $shop->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $shop->user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($shop->activeSubscription)
                                    <div class="text-sm font-medium text-gray-900">{{ $shop->activeSubscription->plan->name }}</div>
                                    <div class="text-xs text-gray-500">Until {{ $shop->activeSubscription->end_date->format('M d, Y') }}</div>
                                @else
                                    <span class="text-sm text-gray-400">No active subscription</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($shop->is_active)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                                        Suspended
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $shop->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.shops.show', $shop) }}" class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition text-sm font-medium">
                                        View
                                    </a>
                                    <form method="POST" action="{{ route('admin.shops.suspend', $shop) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 {{ $shop->is_active ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }} rounded-lg transition text-sm font-medium">
                                            {{ $shop->is_active ? 'Suspend' : 'Activate' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.shops.destroy', $shop) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this shop?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition text-sm font-medium">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <p class="text-gray-500 text-lg font-medium">No shops found</p>
                                    <p class="text-gray-400 text-sm mt-1">Try adjusting your filters</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($shops->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $shops->links() }}
            </div>
        @endif
    </div>

    <!-- Summary -->
    <div class="glass-effect rounded-2xl p-4 shadow-lg">
        <div class="flex items-center justify-between text-sm text-gray-600">
            <span>Showing {{ $shops->firstItem() ?? 0 }} to {{ $shops->lastItem() ?? 0 }} of {{ $shops->total() }} shops</span>
            <span>{{ $shops->currentPage() }} of {{ $shops->lastPage() }} pages</span>
        </div>
    </div>
</div>
@endsection
