<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('สร้างใบแจ้งหนี้') }}
            @if($quotation)
                <span class="text-sm text-gray-600"> - จากใบเสนอราคา {{ $quotation->document_number }}</span>
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('invoices.store') }}" id="invoiceForm">
                        @csrf
                        @if($quotation)
                            <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">
                        @endif

                        <div class="grid md:grid-cols-2 gap-4 mb-6">
                            <!-- Customer -->
                            <div>
                                <x-input-label for="customer_id" :value="__('ลูกค้า *')" />
                                <select id="customer_id" name="customer_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">เลือกลูกค้า</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id', $quotation->customer_id ?? '') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('สถานะ *')" />
                                <select id="status" name="status" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>ฉบับร่าง</option>
                                    <option value="sent" {{ old('status') == 'sent' ? 'selected' : '' }}>ส่งแล้ว</option>
                                    <option value="partial" {{ old('status') == 'partial' ? 'selected' : '' }}>ชำระบางส่วน</option>
                                    <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>ชำระแล้ว</option>
                                    <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>เกินกำหนด</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>ยกเลิก</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Issue Date -->
                            <div>
                                <x-input-label for="issue_date" :value="__('วันที่ออกเอกสาร *')" />
                                <x-text-input id="issue_date" class="block mt-1 w-full" type="date" name="issue_date" :value="old('issue_date', date('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('issue_date')" class="mt-2" />
                            </div>

                            <!-- Due Date -->
                            <div>
                                <x-input-label for="due_date" :value="__('วันครบกำหนด *')" />
                                <x-text-input id="due_date" class="block mt-1 w-full" type="date" name="due_date" :value="old('due_date', date('Y-m-d', strtotime('+30 days')))" required />
                                <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Items Section -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold">รายการสินค้า/บริการ</h3>
                                <button type="button" onclick="addItem()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                    + เพิ่มรายการ
                                </button>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">รายละเอียด</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">จำนวน</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">ราคา/หน่วย</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">ส่วนลด</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">รวม</th>
                                            <th class="px-3 py-2"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsContainer" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Totals -->
                        <div class="mb-6 flex justify-end">
                            <div class="w-full md:w-1/3">
                                <div class="flex justify-between py-2 border-b dark:border-gray-700">
                                    <span>ยอดรวม:</span>
                                    <span id="subtotalDisplay">฿0.00</span>
                                </div>
                                <div class="flex justify-between py-2 border-b dark:border-gray-700">
                                    <span>ภาษี ({{ $shop->settings->tax_rate ?? 0 }}%):</span>
                                    <span id="taxDisplay">฿0.00</span>
                                </div>
                                <div class="flex justify-between py-2 font-bold text-lg">
                                    <span>รวมทั้งสิ้น:</span>
                                    <span id="totalDisplay">฿0.00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Paid Amount -->
                        <div class="mb-4">
                            <x-input-label for="paid_amount" :value="__('ยอดชำระแล้ว')" />
                            <x-text-input id="paid_amount" class="block mt-1 w-full" type="number" step="0.01" name="paid_amount" :value="old('paid_amount', 0)" />
                            <x-input-error :messages="$errors->get('paid_amount')" class="mt-2" />
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <x-input-label for="notes" :value="__('หมายเหตุ')" />
                            <textarea id="notes" name="notes" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ old('notes', $quotation->notes ?? '') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <!-- Terms -->
                        <div class="mb-6">
                            <x-input-label for="terms" :value="__('เงื่อนไขการชำระเงิน')" />
                            <textarea id="terms" name="terms" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ old('terms', $quotation->terms ?? '') }}</textarea>
                            <x-input-error :messages="$errors->get('terms')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('invoices.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
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

    <script>
        let itemIndex = 0;
        const taxRate = {{ $shop->settings->tax_rate ?? 0 }};
        const showTax = {{ $shop->settings->show_tax ? 'true' : 'false' }};
        const quotationItems = @json($quotation->items ?? []);

        function addItem(description = '', quantity = 1, unitPrice = 0, discount = 0) {
            const container = document.getElementById('itemsContainer');
            const row = document.createElement('tr');
            row.id = `item-${itemIndex}`;
            row.innerHTML = `
                <td class="px-3 py-2">
                    <input type="text" name="items[${itemIndex}][description]" value="${description}" required
                           class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm w-full text-sm"
                           placeholder="รายละเอียด">
                </td>
                <td class="px-3 py-2">
                    <input type="number" name="items[${itemIndex}][quantity]" value="${quantity}" step="0.01" min="0" required
                           class="item-quantity border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm w-full text-sm"
                           onchange="calculateItemTotal(${itemIndex})">
                </td>
                <td class="px-3 py-2">
                    <input type="number" name="items[${itemIndex}][unit_price]" value="${unitPrice}" step="0.01" min="0" required
                           class="item-price border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm w-full text-sm"
                           onchange="calculateItemTotal(${itemIndex})">
                </td>
                <td class="px-3 py-2">
                    <input type="number" name="items[${itemIndex}][discount]" value="${discount}" step="0.01" min="0"
                           class="item-discount border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm w-full text-sm"
                           onchange="calculateItemTotal(${itemIndex})">
                </td>
                <td class="px-3 py-2">
                    <span id="item-total-${itemIndex}" class="text-sm">฿0.00</span>
                </td>
                <td class="px-3 py-2">
                    <button type="button" onclick="removeItem(${itemIndex})" class="text-red-600 hover:text-red-900">ลบ</button>
                </td>
            `;
            container.appendChild(row);
            calculateItemTotal(itemIndex);
            itemIndex++;
        }

        function removeItem(index) {
            const row = document.getElementById(`item-${index}`);
            if (row) {
                row.remove();
                calculateTotals();
            }
        }

        function calculateItemTotal(index) {
            const row = document.getElementById(`item-${index}`);
            if (!row) return;

            const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
            const price = parseFloat(row.querySelector('.item-price').value) || 0;
            const discount = parseFloat(row.querySelector('.item-discount').value) || 0;

            const total = (quantity * price) - discount;
            document.getElementById(`item-total-${index}`).textContent = `฿${total.toFixed(2)}`;

            calculateTotals();
        }

        function calculateTotals() {
            let subtotal = 0;
            const items = document.querySelectorAll('#itemsContainer tr');

            items.forEach((row) => {
                const quantity = parseFloat(row.querySelector('.item-quantity')?.value) || 0;
                const price = parseFloat(row.querySelector('.item-price')?.value) || 0;
                const discount = parseFloat(row.querySelector('.item-discount')?.value) || 0;
                subtotal += (quantity * price) - discount;
            });

            const tax = showTax ? (subtotal * (taxRate / 100)) : 0;
            const total = subtotal + tax;

            document.getElementById('subtotalDisplay').textContent = `฿${subtotal.toFixed(2)}`;
            document.getElementById('taxDisplay').textContent = `฿${tax.toFixed(2)}`;
            document.getElementById('totalDisplay').textContent = `฿${total.toFixed(2)}`;
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (quotationItems.length > 0) {
                quotationItems.forEach(item => {
                    addItem(item.description, item.quantity, item.unit_price, item.discount);
                });
            } else {
                addItem();
            }
        });
    </script>
</x-app-layout>
