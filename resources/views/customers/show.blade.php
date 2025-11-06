<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                ลูกค้า: {{ $customer->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('customers.edit', $customer) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    แก้ไข
                </a>
                <a href="{{ route('customers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    กลับ
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Customer Info -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">ข้อมูลลูกค้า</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">รหัสลูกค้า</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->code }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ชื่อ</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">อีเมล</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->email ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">เบอร์โทร</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->phone ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">LINE ID</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->line_id ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">เลขผู้เสียภาษี</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->tax_id ?? '-' }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">ที่อยู่</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->address ?? '-' }}</dd>
                        </div>
                        @if($customer->notes)
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">หมายเหตุ</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->notes }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Documents Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h4 class="text-sm font-medium text-gray-500">ใบเสนอราคา</h4>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $customer->quotations->count() }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h4 class="text-sm font-medium text-gray-500">ใบแจ้งหนี้</h4>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $customer->invoices->count() }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h4 class="text-sm font-medium text-gray-500">ใบเสร็จ</h4>
                    <p class="mt-2 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $customer->receipts->count() }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
