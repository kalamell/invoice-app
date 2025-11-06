<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('ใบเสนอราคา') }} - {{ $quotation->document_number }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('invoices.create', ['quotation_id' => $quotation->id]) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    สร้างใบแจ้งหนี้
                </a>
                <a href="{{ route('quotations.edit', $quotation) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
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
                                <h2 class="text-2xl font-bold text-blue-600">ใบเสนอราคา</h2>
                                <p class="text-lg mt-2">{{ $quotation->document_number }}</p>
                                @php
                                    $statusColors = [
                                        'draft' => 'bg-gray-100 text-gray-800',
                                        'sent' => 'bg-blue-100 text-blue-800',
                                        'accepted' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                    ];
                                    $statusLabels = [
                                        'draft' => 'ฉบับร่าง',
                                        'sent' => 'ส่งแล้ว',
                                        'accepted' => 'ยอมรับ',
                                        'rejected' => 'ปฏิเสธ',
                                    ];
                                @endphp
                                <span class="inline-block mt-2 px-3 py-1 text-sm font-semibold rounded-full {{ $statusColors[$quotation->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$quotation->status] ?? $quotation->status }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Customer & Dates -->
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">ลูกค้า:</h3>
                            <p class="font-bold">{{ $quotation->customer->name }}</p>
                            @if($quotation->customer->address)
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $quotation->customer->address }}</p>
                            @endif
                            @if($quotation->customer->phone)
                                <p class="text-sm text-gray-600 dark:text-gray-400">โทร: {{ $quotation->customer->phone }}</p>
                            @endif
                            @if($quotation->customer->email)
                                <p class="text-sm text-gray-600 dark:text-gray-400">อีเมล: {{ $quotation->customer->email }}</p>
                            @endif
                            @if($quotation->customer->tax_id)
                                <p class="text-sm text-gray-600 dark:text-gray-400">เลขผู้เสียภาษี: {{ $quotation->customer->tax_id }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="mb-2">
                                <span class="text-gray-700 dark:text-gray-300 font-semibold">วันที่ออก:</span>
                                <span class="ml-2">{{ $quotation->issue_date->format('d/m/Y') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-700 dark:text-gray-300 font-semibold">วันหมดอายุ:</span>
                                <span class="ml-2">{{ $quotation->valid_until->format('d/m/Y') }}</span>
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
                                @foreach($quotation->items as $index => $item)
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
                                <span>฿{{ number_format($quotation->subtotal, 2) }}</span>
                            </div>
                            @if($shop->settings->show_tax)
                                <div class="flex justify-between py-2">
                                    <span class="font-semibold">ภาษี ({{ $shop->settings->tax_rate }}%):</span>
                                    <span>฿{{ number_format($quotation->tax_amount, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between py-3 border-t-2 dark:border-gray-700">
                                <span class="text-lg font-bold">รวมทั้งสิ้น:</span>
                                <span class="text-lg font-bold text-blue-600">฿{{ number_format($quotation->total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Notes & Terms -->
                    @if($quotation->notes)
                        <div class="mb-4">
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">หมายเหตุ:</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $quotation->notes }}</p>
                        </div>
                    @endif

                    @if($quotation->terms)
                        <div class="mb-4">
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">เงื่อนไขการชำระเงิน:</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $quotation->terms }}</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex justify-between items-center mt-8 pt-6 border-t dark:border-gray-700">
                        <a href="{{ route('quotations.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                            ← กลับรายการ
                        </a>
                        <div class="flex gap-2">
                            <button onclick="window.print()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                พิมพ์
                            </button>
                            <a href="{{ route('quotations.edit', $quotation) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
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
