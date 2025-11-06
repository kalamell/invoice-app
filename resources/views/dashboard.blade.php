<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $shop->name }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('shop.edit') }}" class="inline-flex items-center px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 hover:shadow-lg transform hover:scale-105 transition duration-300 font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    แก้ไขร้านค้า
                </a>
                <a href="{{ route('shop.settings') }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl hover:shadow-xl transform hover:scale-105 transition duration-300 font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    ตั้งค่า
                </a>
            </div>
        </div>
    </x-slot>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        .animate-slideIn {
            animation: slideIn 0.6s ease-out forwards;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .dark .glass-effect {
            background: rgba(31, 41, 55, 0.95);
            border: 1px solid rgba(75, 85, 99, 0.3);
        }
    </style>

    <div class="py-8 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="glass-effect border border-green-300 text-green-700 px-6 py-4 rounded-2xl relative mb-6 shadow-lg animate-fadeInUp" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Customers -->
                <div class="group glass-effect overflow-hidden shadow-xl rounded-3xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 animate-fadeInUp" style="animation-delay: 0s">
                    <div class="p-6 bg-gradient-to-br from-blue-500/10 to-blue-600/5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">ลูกค้าทั้งหมด</p>
                            <p class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                                {{ number_format($stats['customers_count']) }}
                            </p>
                            <a href="{{ route('customers.index') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700 font-medium mt-3 group-hover:translate-x-1 transition-transform">
                                ดูทั้งหมด
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quotations -->
                <div class="group glass-effect overflow-hidden shadow-xl rounded-3xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 animate-fadeInUp" style="animation-delay: 0.1s">
                    <div class="p-6 bg-gradient-to-br from-purple-500/10 to-purple-600/5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">ใบเสนอราคา</p>
                            <p class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent">
                                {{ number_format($stats['quotations_count']) }}
                            </p>
                            <a href="{{ route('quotations.index') }}" class="inline-flex items-center text-sm text-purple-600 hover:text-purple-700 font-medium mt-3 group-hover:translate-x-1 transition-transform">
                                ดูทั้งหมด
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Invoices -->
                <div class="group glass-effect overflow-hidden shadow-xl rounded-3xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 animate-fadeInUp" style="animation-delay: 0.2s">
                    <div class="p-6 bg-gradient-to-br from-green-500/10 to-green-600/5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">ใบแจ้งหนี้</p>
                            <p class="text-4xl font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent">
                                {{ number_format($stats['invoices_count']) }}
                            </p>
                            <a href="{{ route('invoices.index') }}" class="inline-flex items-center text-sm text-green-600 hover:text-green-700 font-medium mt-3 group-hover:translate-x-1 transition-transform">
                                ดูทั้งหมด
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Receipts -->
                <div class="group glass-effect overflow-hidden shadow-xl rounded-3xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 animate-fadeInUp" style="animation-delay: 0.3s">
                    <div class="p-6 bg-gradient-to-br from-orange-500/10 to-orange-600/5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">ใบเสร็จรับเงิน</p>
                            <p class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-orange-800 bg-clip-text text-transparent">
                                {{ number_format($stats['receipts_count']) }}
                            </p>
                            <a href="{{ route('receipts.index') }}" class="inline-flex items-center text-sm text-orange-600 hover:text-orange-700 font-medium mt-3 group-hover:translate-x-1 transition-transform">
                                ดูทั้งหมด
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-fadeInUp" style="animation-delay: 0.4s">
                <div class="glass-effect overflow-hidden shadow-xl rounded-3xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                    <div class="p-8 bg-gradient-to-br from-blue-500/5 to-purple-500/5">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">ยอดขายรวม</h3>
                        <p class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            ฿{{ number_format($stats['total_invoices_amount'], 2) }}
                        </p>
                    </div>
                </div>

                <div class="glass-effect overflow-hidden shadow-xl rounded-3xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                    <div class="p-8 bg-gradient-to-br from-green-500/5 to-emerald-500/5">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">รับชำระแล้ว</h3>
                        <p class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                            ฿{{ number_format($stats['total_paid_amount'], 2) }}
                        </p>
                        @if($stats['total_invoices_amount'] > 0)
                            <div class="mt-3 text-xs text-gray-600 dark:text-gray-400">
                                {{ number_format(($stats['total_paid_amount'] / $stats['total_invoices_amount']) * 100, 1) }}% ของยอดขายทั้งหมด
                            </div>
                        @endif
                    </div>
                </div>

                <div class="glass-effect overflow-hidden shadow-xl rounded-3xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                    <div class="p-8 bg-gradient-to-br from-orange-500/5 to-red-500/5">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">รอชำระเงิน</h3>
                        <p class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                            ฿{{ number_format($stats['total_pending_amount'], 2) }}
                        </p>
                        @if($stats['total_invoices_amount'] > 0)
                            <div class="mt-3 text-xs text-gray-600 dark:text-gray-400">
                                {{ number_format(($stats['total_pending_amount'] / $stats['total_invoices_amount']) * 100, 1) }}% ของยอดขายทั้งหมด
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="glass-effect overflow-hidden shadow-xl rounded-3xl mb-8 animate-fadeInUp" style="animation-delay: 0.5s">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <svg class="w-6 h-6 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <h3 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">สร้างเอกสารใหม่</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('customers.create') }}" class="group relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 text-white font-semibold py-4 px-6 rounded-2xl text-center hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity"></div>
                            <div class="relative flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                เพิ่มลูกค้า
                            </div>
                        </a>
                        <a href="{{ route('quotations.create') }}" class="group relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 text-white font-semibold py-4 px-6 rounded-2xl text-center hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity"></div>
                            <div class="relative flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                ใบเสนอราคา
                            </div>
                        </a>
                        <a href="{{ route('invoices.create') }}" class="group relative overflow-hidden bg-gradient-to-br from-green-500 to-green-600 text-white font-semibold py-4 px-6 rounded-2xl text-center hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity"></div>
                            <div class="relative flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                </svg>
                                ใบแจ้งหนี้
                            </div>
                        </a>
                        <a href="{{ route('receipts.create') }}" class="group relative overflow-hidden bg-gradient-to-br from-orange-500 to-orange-600 text-white font-semibold py-4 px-6 rounded-2xl text-center hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity"></div>
                            <div class="relative flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                                ใบเสร็จรับเงิน
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-fadeInUp" style="animation-delay: 0.6s">
                <!-- Recent Quotations -->
                <div class="glass-effect overflow-hidden shadow-xl rounded-3xl">
                    <div class="p-6 bg-gradient-to-br from-purple-500/5 to-purple-600/5">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">ใบเสนอราคาล่าสุด</h3>
                            </div>
                            <a href="{{ route('quotations.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">ดูทั้งหมด →</a>
                        </div>
                        @if($stats['recent_quotations']->count() > 0)
                            <div class="space-y-3">
                                @foreach($stats['recent_quotations'] as $quotation)
                                    <a href="{{ route('quotations.show', $quotation) }}" class="block p-4 bg-white/60 dark:bg-gray-800/60 backdrop-blur-sm rounded-2xl border border-purple-100 dark:border-purple-900/30 hover:shadow-lg hover:scale-102 transition-all duration-300">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <p class="font-bold text-gray-900 dark:text-white mb-1">{{ $quotation->document_number }}</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                    {{ $quotation->customer->name }}
                                                </p>
                                            </div>
                                            <div class="text-right ml-4">
                                                <p class="font-bold text-gray-900 dark:text-white mb-2">฿{{ number_format($quotation->total, 2) }}</p>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                    @if($quotation->status === 'accepted') bg-gradient-to-r from-green-400 to-green-500 text-white
                                                    @elseif($quotation->status === 'sent') bg-gradient-to-r from-blue-400 to-blue-500 text-white
                                                    @else bg-gradient-to-r from-gray-400 to-gray-500 text-white
                                                    @endif">
                                                    {{ $quotation->status }}
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 mb-4">ยังไม่มีใบเสนอราคา</p>
                                <a href="{{ route('quotations.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-xl hover:shadow-lg transition-all">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    สร้างใบเสนอราคา
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Invoices -->
                <div class="glass-effect overflow-hidden shadow-xl rounded-3xl">
                    <div class="p-6 bg-gradient-to-br from-green-500/5 to-green-600/5">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">ใบแจ้งหนี้ล่าสุด</h3>
                            </div>
                            <a href="{{ route('invoices.index') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">ดูทั้งหมด →</a>
                        </div>
                        @if($stats['recent_invoices']->count() > 0)
                            <div class="space-y-3">
                                @foreach($stats['recent_invoices'] as $invoice)
                                    <a href="{{ route('invoices.show', $invoice) }}" class="block p-4 bg-white/60 dark:bg-gray-800/60 backdrop-blur-sm rounded-2xl border border-green-100 dark:border-green-900/30 hover:shadow-lg hover:scale-102 transition-all duration-300">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <p class="font-bold text-gray-900 dark:text-white mb-1">{{ $invoice->document_number }}</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                    {{ $invoice->customer->name }}
                                                </p>
                                            </div>
                                            <div class="text-right ml-4">
                                                <p class="font-bold text-gray-900 dark:text-white mb-2">฿{{ number_format($invoice->total, 2) }}</p>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                    @if($invoice->status === 'paid') bg-gradient-to-r from-green-400 to-green-500 text-white
                                                    @elseif($invoice->status === 'sent') bg-gradient-to-r from-blue-400 to-blue-500 text-white
                                                    @elseif($invoice->status === 'overdue') bg-gradient-to-r from-red-400 to-red-500 text-white
                                                    @else bg-gradient-to-r from-gray-400 to-gray-500 text-white
                                                    @endif">
                                                    {{ $invoice->status }}
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 mb-4">ยังไม่มีใบแจ้งหนี้</p>
                                <a href="{{ route('invoices.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:shadow-lg transition-all">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    สร้างใบแจ้งหนี้
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
