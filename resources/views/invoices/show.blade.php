<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('ใบแจ้งหนี้') }} - {{ $invoice->document_number }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('receipts.create', ['invoice_id' => $invoice->id]) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    สร้างใบเสร็จ
                </a>
                <a href="{{ route('invoices.edit', $invoice) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    แก้ไข
                </a>
            </div>
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
                                <h2 class="text-2xl font-bold text-blue-600">ใบแจ้งหนี้</h2>
                                <p class="text-lg mt-2">{{ $invoice->document_number }}</p>
                                @php
                                    $statusColors = [
                                        'draft' => 'bg-gray-100 text-gray-800',
                                        'sent' => 'bg-blue-100 text-blue-800',
                                        'partial' => 'bg-yellow-100 text-yellow-800',
                                        'paid' => 'bg-green-100 text-green-800',
                                        'overdue' => 'bg-red-100 text-red-800',
                                        'cancelled' => 'bg-gray-100 text-gray-800',
                                    ];
                                    $statusLabels = [
                                        'draft' => 'ฉบับร่าง',
                                        'sent' => 'ส่งแล้ว',
                                        'partial' => 'ชำระบางส่วน',
                                        'paid' => 'ชำระแล้ว',
                                        'overdue' => 'เกินกำหนด',
                                        'cancelled' => 'ยกเลิก',
                                    ];
                                @endphp
                                <span class="inline-block mt-2 px-3 py-1 text-sm font-semibold rounded-full {{ $statusColors[$invoice->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$invoice->status] ?? $invoice->status }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Customer & Dates -->
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">ลูกค้า:</h3>
                            <p class="font-bold">{{ $invoice->customer->name }}</p>
                            @if($invoice->customer->address)
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $invoice->customer->address }}</p>
                            @endif
                            @if($invoice->customer->phone)
                                <p class="text-sm text-gray-600 dark:text-gray-400">โทร: {{ $invoice->customer->phone }}</p>
                            @endif
                            @if($invoice->customer->email)
                                <p class="text-sm text-gray-600 dark:text-gray-400">อีเมล: {{ $invoice->customer->email }}</p>
                            @endif
                            @if($invoice->customer->tax_id)
                                <p class="text-sm text-gray-600 dark:text-gray-400">เลขผู้เสียภาษี: {{ $invoice->customer->tax_id }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="mb-2">
                                <span class="text-gray-700 dark:text-gray-300 font-semibold">วันที่ออก:</span>
                                <span class="ml-2">{{ $invoice->issue_date->format('d/m/Y') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-700 dark:text-gray-300 font-semibold">วันครบกำหนด:</span>
                                <span class="ml-2">{{ $invoice->due_date->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="mb-6">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">รายการ</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">จำนวน</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ราคา/หน่วย</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ส่วนลด</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">รวม</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($invoice->items as $index => $item)
                                    <tr>
                                        <td class="px-4 py-3 text-sm">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $item->description }}</td>
                                        <td class="px-4 py-3 text-sm text-right">{{ number_format($item->quantity, 2) }}</td>
                                        <td class="px-4 py-3 text-sm text-right">฿{{ number_format($item->unit_price, 2) }}</td>
                                        <td class="px-4 py-3 text-sm text-right">฿{{ number_format($item->discount, 2) }}</td>
                                        <td class="px-4 py-3 text-sm text-right font-semibold">฿{{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Totals -->
                    <div class="flex justify-end mb-6">
                        <div class="w-full md:w-1/2">
                            <div class="flex justify-between py-2 border-t dark:border-gray-700">
                                <span class="font-semibold">ยอดรวม:</span>
                                <span>฿{{ number_format($invoice->subtotal, 2) }}</span>
                            </div>
                            @if($shop->settings->show_tax)
                                <div class="flex justify-between py-2">
                                    <span class="font-semibold">ภาษี ({{ $shop->settings->tax_rate }}%):</span>
                                    <span>฿{{ number_format($invoice->tax_amount, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between py-3 border-t-2 dark:border-gray-700">
                                <span class="text-lg font-bold">รวมทั้งสิ้น:</span>
                                <span class="text-lg font-bold text-blue-600">฿{{ number_format($invoice->total, 2) }}</span>
                            </div>
                            @if($invoice->paid_amount > 0)
                                <div class="flex justify-between py-2 text-green-600">
                                    <span class="font-semibold">ชำระแล้ว:</span>
                                    <span>฿{{ number_format($invoice->paid_amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-t dark:border-gray-700 text-red-600">
                                    <span class="font-semibold">คงเหลือ:</span>
                                    <span>฿{{ number_format($invoice->total - $invoice->paid_amount, 2) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- PromptPay QR Code -->
                    @if($shop->settings->promptpay_id && $invoice->status !== 'paid' && $invoice->status !== 'cancelled')
                        <div class="mb-6 p-6 bg-blue-50 dark:bg-blue-900 rounded-lg text-center no-print">
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-4">ชำระเงินผ่าน PromptPay</h3>
                            <div class="flex flex-col items-center">
                                @php
                                    $remainingAmount = $invoice->total - $invoice->paid_amount;
                                    $qrCode = generatePromptPayQR($shop->settings->promptpay_id, $remainingAmount);
                                @endphp
                                <img src="{{ $qrCode }}" alt="PromptPay QR Code" class="w-48 h-48 mb-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    สแกน QR Code เพื่อชำระเงิน
                                </p>
                                @if($shop->settings->promptpay_name)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $shop->settings->promptpay_name }}
                                    </p>
                                @endif
                                <p class="text-lg font-bold text-blue-600 mt-2">
                                    ฿{{ number_format($remainingAmount, 2) }}
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Notes & Terms -->
                    @if($invoice->notes)
                        <div class="mb-4">
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">หมายเหตุ:</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $invoice->notes }}</p>
                        </div>
                    @endif

                    @if($invoice->terms)
                        <div class="mb-4">
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">เงื่อนไขการชำระเงิน:</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $invoice->terms }}</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex justify-between items-center mt-8 pt-6 border-t dark:border-gray-700">
                        <a href="{{ route('invoices.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                            ← กลับรายการ
                        </a>
                        <div class="flex gap-2">
                            <a href="{{ route('invoices.pdf', $invoice) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                ดาวน์โหลด PDF
                            </a>
                            <button onclick="window.print()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                พิมพ์
                            </button>
                            <a href="{{ route('invoices.edit', $invoice) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                แก้ไข
                            </a>
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
