<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent leading-tight">
                    {{ __('ใบแจ้งหนี้') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">จัดการใบแจ้งหนี้และติดตามการชำระเงิน</p>
            </div>
            <a href="{{ route('invoices.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-2xl hover:shadow-2xl transform hover:scale-105 transition duration-300 font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                สร้างใบแจ้งหนี้
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
                    @if($invoices->count() > 0)
                        <!-- Table for desktop -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b-2 border-green-200 dark:border-green-900">
                                        <th class="px-6 py-4 text-left text-xs font-bold text-green-600 dark:text-green-400 uppercase tracking-wider">เลขที่</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-green-600 dark:text-green-400 uppercase tracking-wider">ลูกค้า</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-green-600 dark:text-green-400 uppercase tracking-wider">วันที่ออก</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-green-600 dark:text-green-400 uppercase tracking-wider">วันครบกำหนด</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-green-600 dark:text-green-400 uppercase tracking-wider">ยอดรวม</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-green-600 dark:text-green-400 uppercase tracking-wider">ชำระแล้ว</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-green-600 dark:text-green-400 uppercase tracking-wider">สถานะ</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-green-600 dark:text-green-400 uppercase tracking-wider">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($invoices as $invoice)
                                        <tr class="hover:bg-green-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('invoices.show', $invoice) }}" class="text-sm font-bold text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                                    {{ $invoice->document_number }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center mr-3">
                                                        <span class="text-white text-xs font-bold">{{ substr($invoice->customer->name, 0, 1) }}</span>
                                                    </div>
                                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $invoice->customer->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                                {{ $invoice->issue_date->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                                {{ $invoice->due_date->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-gray-100">
                                                ฿{{ number_format($invoice->total, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600 dark:text-green-400">
                                                ฿{{ number_format($invoice->paid_amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusConfig = [
                                                        'draft' => ['label' => 'ฉบับร่าง', 'gradient' => 'from-gray-400 to-gray-500'],
                                                        'sent' => ['label' => 'ส่งแล้ว', 'gradient' => 'from-blue-400 to-blue-500'],
                                                        'partial' => ['label' => 'ชำระบางส่วน', 'gradient' => 'from-yellow-400 to-yellow-500'],
                                                        'paid' => ['label' => 'ชำระแล้ว', 'gradient' => 'from-green-400 to-green-500'],
                                                        'overdue' => ['label' => 'เกินกำหนด', 'gradient' => 'from-red-400 to-red-500'],
                                                        'cancelled' => ['label' => 'ยกเลิก', 'gradient' => 'from-gray-400 to-gray-500'],
                                                    ];
                                                    $config = $statusConfig[$invoice->status] ?? ['label' => $invoice->status, 'gradient' => 'from-gray-400 to-gray-500'];
                                                @endphp
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r {{ $config['gradient'] }} text-white shadow-lg">
                                                    {{ $config['label'] }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <a href="{{ route('invoices.show', $invoice) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                        ดู
                                                    </a>
                                                    <a href="{{ route('invoices.edit', $invoice) }}" class="inline-flex items-center px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        แก้ไข
                                                    </a>
                                                    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline" onsubmit="return confirm('แน่ใจหรือไม่ที่จะลบ?');">
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
                            @foreach($invoices as $invoice)
                                <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-sm rounded-2xl p-5 border border-green-100 dark:border-green-900/30 hover:shadow-lg transition-all duration-300">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <a href="{{ route('invoices.show', $invoice) }}" class="text-lg font-bold text-green-600 hover:text-green-800 dark:text-green-400">
                                                {{ $invoice->document_number }}
                                            </a>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                ออก: {{ $invoice->issue_date->format('d/m/Y') }}
                                                <br>
                                                ครบ: {{ $invoice->due_date->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        @php
                                            $statusConfig = [
                                                'draft' => ['label' => 'ฉบับร่าง', 'gradient' => 'from-gray-400 to-gray-500'],
                                                'sent' => ['label' => 'ส่งแล้ว', 'gradient' => 'from-blue-400 to-blue-500'],
                                                'partial' => ['label' => 'ชำระบางส่วน', 'gradient' => 'from-yellow-400 to-yellow-500'],
                                                'paid' => ['label' => 'ชำระแล้ว', 'gradient' => 'from-green-400 to-green-500'],
                                                'overdue' => ['label' => 'เกินกำหนด', 'gradient' => 'from-red-400 to-red-500'],
                                                'cancelled' => ['label' => 'ยกเลิก', 'gradient' => 'from-gray-400 to-gray-500'],
                                            ];
                                            $config = $statusConfig[$invoice->status] ?? ['label' => $invoice->status, 'gradient' => 'from-gray-400 to-gray-500'];
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r {{ $config['gradient'] }} text-white">
                                            {{ $config['label'] }}
                                        </span>
                                    </div>
                                    <div class="flex items-center mb-4">
                                        <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center mr-3">
                                            <span class="text-white text-xs font-bold">{{ substr($invoice->customer->name, 0, 1) }}</span>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $invoice->customer->name }}</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700">
                                        <div>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">ยอดรวม</p>
                                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">฿{{ number_format($invoice->total, 2) }}</p>
                                            <p class="text-xs text-green-600 dark:text-green-400 mt-1">ชำระแล้ว: ฿{{ number_format($invoice->paid_amount, 2) }}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('invoices.show', $invoice) }}" class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('invoices.edit', $invoice) }}" class="p-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline" onsubmit="return confirm('แน่ใจหรือไม่ที่จะลบ?');">
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
                            {{ $invoices->links() }}
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900 dark:to-green-800 rounded-3xl mb-6">
                                <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">ยังไม่มีใบแจ้งหนี้</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-8">เริ่มต้นด้วยการสร้างใบแจ้งหนี้แรกของคุณ</p>
                            <a href="{{ route('invoices.create') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white text-lg font-semibold rounded-2xl hover:shadow-2xl transform hover:scale-105 transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
</x-app-layout>
