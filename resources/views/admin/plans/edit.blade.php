@extends('admin.layouts.admin')

@section('title', 'Edit Plan')
@section('header', 'Edit Plan')
@section('description', 'Edit subscription plan: ' . $plan->name)

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.plans.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Plans
        </a>
    </div>

    <!-- Form Card -->
    <div class="glass-effect rounded-2xl p-8 shadow-lg max-w-4xl">
        <form method="POST" action="{{ route('admin.plans.update', $plan) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Basic Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Plan Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $plan->name) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="e.g., Basic Plan, Pro Plan">
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            Price (฿) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="price" id="price" value="{{ old('price', $plan->price) }}" step="0.01" min="0" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="0.00">
                    </div>

                    <div>
                        <label for="duration_days" class="block text-sm font-medium text-gray-700 mb-2">
                            Duration (Days) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="duration_days" id="duration_days" value="{{ old('duration_days', $plan->duration_days) }}" min="1" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="30">
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                            Sort Order
                        </label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $plan->sort_order) }}" min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="0">
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                  placeholder="Describe what this plan includes...">{{ old('description', $plan->description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Limits -->
            <div class="pt-6 border-t border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Limits
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="max_documents" class="block text-sm font-medium text-gray-700 mb-2">
                            Max Documents
                        </label>
                        <input type="number" name="max_documents" id="max_documents" value="{{ old('max_documents', $plan->max_documents) }}" min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="Leave empty for unlimited">
                        <p class="text-xs text-gray-500 mt-1">Leave empty for unlimited documents</p>
                    </div>

                    <div>
                        <label for="max_customers" class="block text-sm font-medium text-gray-700 mb-2">
                            Max Customers
                        </label>
                        <input type="number" name="max_customers" id="max_customers" value="{{ old('max_customers', $plan->max_customers) }}" min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="Leave empty for unlimited">
                        <p class="text-xs text-gray-500 mt-1">Leave empty for unlimited customers</p>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="pt-6 border-t border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Features
                </h3>
                <div class="space-y-4">
                    <label class="flex items-center space-x-3 cursor-pointer group">
                        <input type="checkbox" name="can_send_line" value="1" {{ old('can_send_line', $plan->can_send_line) ? 'checked' : '' }}
                               class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        <div>
                            <div class="font-medium text-gray-900 group-hover:text-purple-600 transition">
                                Can Send via LINE
                            </div>
                            <div class="text-sm text-gray-500">
                                Allow users to send documents through LINE messaging
                            </div>
                        </div>
                    </label>

                    <label class="flex items-center space-x-3 cursor-pointer group">
                        <input type="checkbox" name="can_customize_template" value="1" {{ old('can_customize_template', $plan->can_customize_template) ? 'checked' : '' }}
                               class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        <div>
                            <div class="font-medium text-gray-900 group-hover:text-purple-600 transition">
                                Can Customize Templates
                            </div>
                            <div class="text-sm text-gray-500">
                                Allow users to customize document templates with their branding
                            </div>
                        </div>
                    </label>

                    <label class="flex items-center space-x-3 cursor-pointer group">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }}
                               class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        <div>
                            <div class="font-medium text-gray-900 group-hover:text-purple-600 transition">
                                Active Plan
                            </div>
                            <div class="text-sm text-gray-500">
                                Make this plan available for subscription
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Plan Stats -->
            <div class="pt-6 border-t border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Plan Statistics
                </h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <div class="text-sm text-gray-600">Total Subscriptions</div>
                            <div class="text-2xl font-bold text-gray-900">{{ $plan->subscriptions()->count() }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Active Subscriptions</div>
                            <div class="text-2xl font-bold text-green-600">{{ $plan->subscriptions()->where('status', 'active')->count() }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Total Revenue</div>
                            <div class="text-2xl font-bold text-blue-600">฿{{ number_format($plan->subscriptions()->sum('amount'), 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:shadow-lg transform hover:scale-105 transition duration-300 font-semibold">
                    Update Plan
                </button>
                <a href="{{ route('admin.plans.index') }}" class="px-8 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
