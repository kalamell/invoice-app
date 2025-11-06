<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }} - {{ $shop->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('shop.edit') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    แก้ไขร้านค้า
                </a>
                <a href="{{ route('shop.settings') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    ตั้งค่า
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Customers -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-12 w-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        ลูกค้าทั้งหมด
                                    </dt>
                                    <dd class="text-3xl font-semibold text-gray-900 dark:text-white">
                                        {{ number_format($stats['customers_count']) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('customers.index') }}" class="text-sm text-blue-600 hover:text-blue-500">ดูทั้งหมด →</a>
                        </div>
                    </div>
                </div>

                <!-- Quotations -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-12 w-12 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        ใบเสนอราคา
                                    </dt>
                                    <dd class="text-3xl font-semibold text-gray-900 dark:text-white">
                                        {{ number_format($stats['quotations_count']) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('quotations.index') }}" class="text-sm text-purple-600 hover:text-purple-500">ดูทั้งหมด →</a>
                        </div>
                    </div>
                </div>

                <!-- Invoices -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        ใบแจ้งหนี้
                                    </dt>
                                    <dd class="text-3xl font-semibold text-gray-900 dark:text-white">
                                        {{ number_format($stats['invoices_count']) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('invoices.index') }}" class="text-sm text-green-600 hover:text-green-500">ดูทั้งหมด →</a>
                        </div>
                    </div>
                </div>

                <!-- Receipts -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-12 w-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        ใบเสร็จรับเงิน
                                    </dt>
                                    <dd class="text-3xl font-semibold text-gray-900 dark:text-white">
                                        {{ number_format($stats['receipts_count']) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('receipts.index') }}" class="text-sm text-orange-600 hover:text-orange-500">ดูทั้งหมด →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">ยอดขายรวม</h3>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                            ฿{{ number_format($stats['total_invoices_amount'], 2) }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">รับชำระแล้ว</h3>
                        <p class="text-2xl font-bold text-green-600 mt-2">
                            ฿{{ number_format($stats['total_paid_amount'], 2) }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">รอชำระเงิน</h3>
                        <p class="text-2xl font-bold text-orange-600 mt-2">
                            ฿{{ number_format($stats['total_pending_amount'], 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">สร้างเอกสารใหม่</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <a href="{{ route('customers.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded text-center">
                            + เพิ่มลูกค้า
                        </a>
                        <a href="{{ route('quotations.create') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded text-center">
                            + ใบเสนอราคา
                        </a>
                        <a href="{{ route('invoices.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded text-center">
                            + ใบแจ้งหนี้
                        </a>
                        <a href="{{ route('receipts.create') }}" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-3 px-4 rounded text-center">
                            + ใบเสร็จรับเงิน
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Recent Quotations -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">ใบเสนอราคาล่าสุด</h3>
                        @if($stats['recent_quotations']->count() > 0)
                            <div class="space-y-3">
                                @foreach($stats['recent_quotations'] as $quotation)
                                    <div class="border-b pb-3">
                                        <div class="flex justify-between">
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $quotation->document_number }}</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $quotation->customer->name }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-semibold text-gray-900 dark:text-white">฿{{ number_format($quotation->total, 2) }}</p>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($quotation->status === 'accepted') bg-green-100 text-green-800
                                                    @elseif($quotation->status === 'sent') bg-blue-100 text-blue-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                                    {{ $quotation->status }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">ยังไม่มีใบเสนอราคา</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Invoices -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">ใบแจ้งหนี้ล่าสุด</h3>
                        @if($stats['recent_invoices']->count() > 0)
                            <div class="space-y-3">
                                @foreach($stats['recent_invoices'] as $invoice)
                                    <div class="border-b pb-3">
                                        <div class="flex justify-between">
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $invoice->document_number }}</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $invoice->customer->name }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-semibold text-gray-900 dark:text-white">฿{{ number_format($invoice->total, 2) }}</p>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($invoice->status === 'paid') bg-green-100 text-green-800
                                                    @elseif($invoice->status === 'sent') bg-blue-100 text-blue-800
                                                    @elseif($invoice->status === 'overdue') bg-red-100 text-red-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                                    {{ $invoice->status }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">ยังไม่มีใบแจ้งหนี้</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
