<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent leading-tight">
                    {{ __('ใบเสร็จรับเงิน') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">จัดการใบเสร็จรับเงินของคุณ</p>
            </div>
            <a href="{{ route('receipts.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-2xl hover:shadow-2xl transform hover:scale-105 transition duration-300 font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                สร้างใบเสร็จ
            </a>
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
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
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

            <div class="glass-effect overflow-hidden shadow-2xl rounded-3xl animate-fadeInUp">
                <div class="p-6 sm:p-8 text-gray-900 dark:text-gray-100">
                    @if($receipts->count() > 0)
                        <!-- Table for desktop -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b-2 border-orange-200 dark:border-orange-900">
                                        <th class="px-6 py-4 text-left text-xs font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wider">เลขที่</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wider">ลูกค้า</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wider">ใบแจ้งหนี้</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wider">วันที่ออก</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wider">ยอดเงิน</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wider">ช่องทางชำระ</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wider">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($receipts as $receipt)
                                        <tr class="hover:bg-orange-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('receipts.show', $receipt) }}" class="text-sm font-bold text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-300">
                                                    {{ $receipt->document_number }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg flex items-center justify-center mr-3">
                                                        <span class="text-white text-xs font-bold">{{ substr($receipt->customer->name, 0, 1) }}</span>
                                                    </div>
                                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $receipt->customer->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                                @if($receipt->invoice)
                                                    <a href="{{ route('invoices.show', $receipt->invoice) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 font-medium">
                                                        {{ $receipt->invoice->document_number }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                                {{ $receipt->issue_date->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-gray-100">
                                                ฿{{ number_format($receipt->amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $paymentMethods = [
                                                        'cash' => ['label' => 'เงินสด', 'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z'],
                                                        'transfer' => ['label' => 'โอนเงิน', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
                                                        'cheque' => ['label' => 'เช็ค', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                                        'credit_card' => ['label' => 'บัตรเครดิต', 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                                                        'promptpay' => ['label' => 'พร้อมเพย์', 'icon' => 'M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z'],
                                                    ];
                                                    $method = $paymentMethods[$receipt->payment_method] ?? ['label' => $receipt->payment_method, 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'];
                                                @endphp
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 bg-gradient-to-br from-orange-100 to-orange-200 dark:from-orange-900 dark:to-orange-800 rounded-lg flex items-center justify-center mr-2">
                                                        <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $method['icon'] }}"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $method['label'] }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <a href="{{ route('receipts.show', $receipt) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                        ดู
                                                    </a>
                                                    <form action="{{ route('receipts.destroy', $receipt) }}" method="POST" class="inline" onsubmit="return confirm('แน่ใจหรือไม่ที่จะลบ?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                            ลบ
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Cards for mobile -->
                        <div class="lg:hidden space-y-4">
                            @foreach($receipts as $receipt)
                                <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-sm rounded-2xl p-5 border border-orange-100 dark:border-orange-900/30 hover:shadow-lg transition-all duration-300">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <a href="{{ route('receipts.show', $receipt) }}" class="text-lg font-bold text-orange-600 hover:text-orange-800 dark:text-orange-400">
                                                {{ $receipt->document_number }}
                                            </a>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $receipt->issue_date->format('d/m/Y') }}</p>
                                        </div>
                                        @php
                                            $paymentMethods = [
                                                'cash' => 'เงินสด',
                                                'transfer' => 'โอนเงิน',
                                                'cheque' => 'เช็ค',
                                                'credit_card' => 'บัตรเครดิต',
                                                'promptpay' => 'พร้อมเพย์',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-orange-400 to-orange-500 text-white">
                                            {{ $paymentMethods[$receipt->payment_method] ?? $receipt->payment_method }}
                                        </span>
                                    </div>
                                    <div class="flex items-center mb-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg flex items-center justify-center mr-3">
                                            <span class="text-white text-xs font-bold">{{ substr($receipt->customer->name, 0, 1) }}</span>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $receipt->customer->name }}</span>
                                    </div>
                                    @if($receipt->invoice)
                                        <div class="mb-3 text-sm">
                                            <span class="text-gray-600 dark:text-gray-400">ใบแจ้งหนี้: </span>
                                            <a href="{{ route('invoices.show', $receipt->invoice) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 font-medium">
                                                {{ $receipt->invoice->document_number }}
                                            </a>
                                        </div>
                                    @endif
                                    <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700">
                                        <span class="text-lg font-bold text-gray-900 dark:text-gray-100">฿{{ number_format($receipt->amount, 2) }}</span>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('receipts.show', $receipt) }}" class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('receipts.destroy', $receipt) }}" method="POST" class="inline" onsubmit="return confirm('แน่ใจหรือไม่ที่จะลบ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $receipts->links() }}
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-orange-100 to-orange-200 dark:from-orange-900 dark:to-orange-800 rounded-3xl mb-6">
                                <svg class="w-10 h-10 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">ยังไม่มีใบเสร็จรับเงิน</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-8">เริ่มต้นด้วยการสร้างใบเสร็จรับเงินแรกของคุณ</p>
                            <a href="{{ route('receipts.create') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-600 to-red-600 text-white text-lg font-semibold rounded-2xl hover:shadow-2xl transform hover:scale-105 transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                สร้างใบเสร็จ
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
