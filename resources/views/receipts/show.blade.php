<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('ใบเสร็จรับเงิน') }} - {{ $receipt->document_number }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <!-- Header -->
                    <div class="border-b-2 pb-6 mb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $shop->name }}</h1>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $shop->address }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">โทร: {{ $shop->phone }}</p>
                                @if($shop->email)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">อีเมล: {{ $shop->email }}</p>
                                @endif
                                @if($shop->tax_id)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">เลขผู้เสียภาษี: {{ $shop->tax_id }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <h2 class="text-2xl font-bold text-green-600">ใบเสร็จรับเงิน</h2>
                                <p class="text-lg mt-2">{{ $receipt->document_number }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Customer & Details -->
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">ลูกค้า:</h3>
                            <p class="font-bold">{{ $receipt->customer->name }}</p>
                            @if($receipt->customer->address)
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $receipt->customer->address }}</p>
                            @endif
                            @if($receipt->customer->phone)
                                <p class="text-sm text-gray-600 dark:text-gray-400">โทร: {{ $receipt->customer->phone }}</p>
                            @endif
                            @if($receipt->customer->email)
                                <p class="text-sm text-gray-600 dark:text-gray-400">อีเมล: {{ $receipt->customer->email }}</p>
                            @endif
                            @if($receipt->customer->tax_id)
                                <p class="text-sm text-gray-600 dark:text-gray-400">เลขผู้เสียภาษี: {{ $receipt->customer->tax_id }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="mb-2">
                                <span class="text-gray-700 dark:text-gray-300 font-semibold">วันที่ออก:</span>
                                <span class="ml-2">{{ $receipt->issue_date->format('d/m/Y') }}</span>
                            </div>
                            @if($receipt->invoice)
                                <div class="mb-2">
                                    <span class="text-gray-700 dark:text-gray-300 font-semibold">ใบแจ้งหนี้:</span>
                                    <a href="{{ route('invoices.show', $receipt->invoice) }}" class="ml-2 text-blue-600 hover:text-blue-900">
                                        {{ $receipt->invoice->document_number }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Details -->
                    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-4">รายละเอียดการชำระเงิน:</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">ช่องทางชำระเงิน:</span>
                                <span class="ml-2 font-semibold">
                                    @php
                                        $paymentMethods = [
                                            'cash' => 'เงินสด',
                                            'transfer' => 'โอนเงิน',
                                            'cheque' => 'เช็ค',
                                            'credit_card' => 'บัตรเครดิต',
                                            'promptpay' => 'พร้อมเพย์',
                                        ];
                                    @endphp
                                    {{ $paymentMethods[$receipt->payment_method] ?? $receipt->payment_method }}
                                </span>
                            </div>
                            @if($receipt->payment_reference)
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">หมายเลขอ้างอิง:</span>
                                    <span class="ml-2 font-semibold">{{ $receipt->payment_reference }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="mb-6 p-6 bg-green-50 dark:bg-green-900 rounded-lg text-center">
                        <p class="text-gray-600 dark:text-gray-300 mb-2">ยอดเงินที่ชำระ</p>
                        <p class="text-4xl font-bold text-green-600 dark:text-green-300">฿{{ number_format($receipt->amount, 2) }}</p>
                    </div>

                    <!-- Notes -->
                    @if($receipt->notes)
                        <div class="mb-4">
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">หมายเหตุ:</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $receipt->notes }}</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex justify-between items-center mt-8 pt-6 border-t dark:border-gray-700">
                        <a href="{{ route('receipts.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                            ← กลับรายการ
                        </a>
                        <div class="flex gap-2">
                            <button onclick="window.print()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                พิมพ์
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .print-area, .print-area * {
                visibility: visible;
            }
            .print-area {
                position: absolute;
                left: 0;
                top: 0;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</x-app-layout>
