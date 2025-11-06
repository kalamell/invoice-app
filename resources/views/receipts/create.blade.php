<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('สร้างใบเสร็จรับเงิน') }}
            @if($invoice)
                <span class="text-sm text-gray-600"> - จากใบแจ้งหนี้ {{ $invoice->document_number }}</span>
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('receipts.store') }}">
                        @csrf
                        @if($invoice)
                            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                        @endif

                        <div class="grid md:grid-cols-2 gap-4 mb-6">
                            <!-- Customer -->
                            <div>
                                <x-input-label for="customer_id" :value="__('ลูกค้า *')" />
                                <select id="customer_id" name="customer_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">เลือกลูกค้า</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id', $invoice->customer_id ?? '') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
                            </div>

                            <!-- Issue Date -->
                            <div>
                                <x-input-label for="issue_date" :value="__('วันที่ออกเอกสาร *')" />
                                <x-text-input id="issue_date" class="block mt-1 w-full" type="date" name="issue_date" :value="old('issue_date', date('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('issue_date')" class="mt-2" />
                            </div>

                            <!-- Amount -->
                            <div>
                                <x-input-label for="amount" :value="__('จำนวนเงิน *')" />
                                <x-text-input id="amount" class="block mt-1 w-full" type="number" step="0.01" name="amount" :value="old('amount', $invoice ? $invoice->total - $invoice->paid_amount : 0)" required />
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                                @if($invoice)
                                    <p class="text-xs text-gray-500 mt-1">
                                        ยอดคงเหลือ: ฿{{ number_format($invoice->total - $invoice->paid_amount, 2) }}
                                    </p>
                                @endif
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <x-input-label for="payment_method" :value="__('ช่องทางชำระเงิน *')" />
                                <select id="payment_method" name="payment_method" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>เงินสด</option>
                                    <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>โอนเงิน</option>
                                    <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>เช็ค</option>
                                    <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>บัตรเครดิต</option>
                                    <option value="promptpay" {{ old('payment_method') == 'promptpay' ? 'selected' : '' }}>พร้อมเพย์</option>
                                </select>
                                <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Payment Reference -->
                        <div class="mb-4">
                            <x-input-label for="payment_reference" :value="__('หมายเลขอ้างอิง')" />
                            <x-text-input id="payment_reference" class="block mt-1 w-full" type="text" name="payment_reference" :value="old('payment_reference')" />
                            <p class="text-xs text-gray-500 mt-1">เลขที่เช็ค, เลขที่การโอน, หรืออ้างอิงอื่นๆ</p>
                            <x-input-error :messages="$errors->get('payment_reference')" class="mt-2" />
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <x-input-label for="notes" :value="__('หมายเหตุ')" />
                            <textarea id="notes" name="notes" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('receipts.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                                ← กลับ
                            </a>
                            <x-primary-button>
                                {{ __('บันทึก') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
