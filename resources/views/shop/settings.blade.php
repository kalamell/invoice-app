<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ตั้งค่าร้านค้า') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('shop.settings.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4">การตั้งค่าเอกสาร</h3>

                                <!-- Document Prefix -->
                                <div class="mb-4">
                                    <x-input-label for="document_prefix" :value="__('คำนำหน้าเลขเอกสาร')" />
                                    <x-text-input id="document_prefix" class="block mt-1 w-full" type="text" name="document_prefix" :value="old('document_prefix', $settings->document_prefix ?? 'INV')" required />
                                    <p class="text-xs text-gray-500 mt-1">เช่น INV, QT, RC (สูงสุด 10 ตัวอักษร)</p>
                                    <x-input-error :messages="$errors->get('document_prefix')" class="mt-2" />
                                </div>

                                <!-- Primary Color -->
                                <div class="mb-4">
                                    <x-input-label for="primary_color" :value="__('สีหลัก')" />
                                    <div class="flex items-center gap-2">
                                        <input id="primary_color" type="color" name="primary_color" value="{{ old('primary_color', $settings->primary_color ?? '#0ea5e9') }}" class="h-10 w-20 rounded border border-gray-300" required />
                                        <x-text-input id="primary_color_text" class="block w-full" type="text" value="{{ old('primary_color', $settings->primary_color ?? '#0ea5e9') }}" readonly />
                                    </div>
                                    <x-input-error :messages="$errors->get('primary_color')" class="mt-2" />
                                </div>

                                <!-- Secondary Color -->
                                <div class="mb-4">
                                    <x-input-label for="secondary_color" :value="__('สีรอง')" />
                                    <div class="flex items-center gap-2">
                                        <input id="secondary_color" type="color" name="secondary_color" value="{{ old('secondary_color', $settings->secondary_color ?? '#0369a1') }}" class="h-10 w-20 rounded border border-gray-300" required />
                                        <x-text-input id="secondary_color_text" class="block w-full" type="text" value="{{ old('secondary_color', $settings->secondary_color ?? '#0369a1') }}" readonly />
                                    </div>
                                    <x-input-error :messages="$errors->get('secondary_color')" class="mt-2" />
                                </div>

                                <!-- Font Family -->
                                <div class="mb-4">
                                    <x-input-label for="font_family" :value="__('ฟอนต์')" />
                                    <select id="font_family" name="font_family" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                        <option value="Sarabun" {{ old('font_family', $settings->font_family ?? 'Sarabun') == 'Sarabun' ? 'selected' : '' }}>Sarabun (แนะนำ)</option>
                                        <option value="Prompt" {{ old('font_family', $settings->font_family) == 'Prompt' ? 'selected' : '' }}>Prompt</option>
                                        <option value="Kanit" {{ old('font_family', $settings->font_family) == 'Kanit' ? 'selected' : '' }}>Kanit</option>
                                        <option value="Mitr" {{ old('font_family', $settings->font_family) == 'Mitr' ? 'selected' : '' }}>Mitr</option>
                                        <option value="Arial" {{ old('font_family', $settings->font_family) == 'Arial' ? 'selected' : '' }}>Arial</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('font_family')" class="mt-2" />
                                </div>

                                <!-- Footer Text -->
                                <div class="mb-4">
                                    <x-input-label for="footer_text" :value="__('ข้อความท้ายเอกสาร')" />
                                    <textarea id="footer_text" name="footer_text" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ old('footer_text', $settings->footer_text) }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">ข้อความที่จะแสดงด้านล่างของเอกสาร เช่น "ขอบคุณที่ใช้บริการ"</p>
                                    <x-input-error :messages="$errors->get('footer_text')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4">ภาษีและการชำระเงิน</h3>

                                <!-- Show Tax -->
                                <div class="mb-4">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="show_tax" value="1" {{ old('show_tax', $settings->show_tax ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">แสดง VAT ในเอกสาร</span>
                                    </label>
                                </div>

                                <!-- Tax Rate -->
                                <div class="mb-4">
                                    <x-input-label for="tax_rate" :value="__('อัตราภาษี (%)')" />
                                    <x-text-input id="tax_rate" class="block mt-1 w-full" type="number" step="0.01" min="0" max="100" name="tax_rate" :value="old('tax_rate', $settings->tax_rate ?? 7.00)" required />
                                    <p class="text-xs text-gray-500 mt-1">อัตราภาษีมูลค่าเพิ่ม (VAT) ปกติ 7%</p>
                                    <x-input-error :messages="$errors->get('tax_rate')" class="mt-2" />
                                </div>

                                <h3 class="text-lg font-semibold mb-4 mt-6">PromptPay QR Code</h3>

                                <!-- PromptPay ID -->
                                <div class="mb-4">
                                    <x-input-label for="promptpay_id" :value="__('เลข PromptPay')" />
                                    <x-text-input id="promptpay_id" class="block mt-1 w-full" type="text" name="promptpay_id" :value="old('promptpay_id', $settings->promptpay_id)" placeholder="0812345678 หรือ 0123456789012" />
                                    <p class="text-xs text-gray-500 mt-1">เบอร์มือถือ หรือ เลขประจำตัวผู้เสียภาษี 13 หัก</p>
                                    <x-input-error :messages="$errors->get('promptpay_id')" class="mt-2" />
                                </div>

                                <!-- PromptPay Name -->
                                <div class="mb-4">
                                    <x-input-label for="promptpay_name" :value="__('ชื่อบัญชี PromptPay')" />
                                    <x-text-input id="promptpay_name" class="block mt-1 w-full" type="text" name="promptpay_name" :value="old('promptpay_name', $settings->promptpay_name)" placeholder="ชื่อร้านค้า หรือ ชื่อบัญชี" />
                                    <x-input-error :messages="$errors->get('promptpay_name')" class="mt-2" />
                                </div>

                                <!-- Preview Box -->
                                <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <h4 class="text-sm font-semibold mb-2">ตัวอย่างสี</h4>
                                    <div class="flex gap-2">
                                        <div id="preview_primary" style="background-color: {{ $settings->primary_color ?? '#0ea5e9' }};" class="w-20 h-20 rounded shadow"></div>
                                        <div id="preview_secondary" style="background-color: {{ $settings->secondary_color ?? '#0369a1' }};" class="w-20 h-20 rounded shadow"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                                ← กลับ
                            </a>
                            <x-primary-button class="ml-4">
                                {{ __('บันทึกการตั้งค่า') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update color preview and text input
        document.getElementById('primary_color').addEventListener('input', function(e) {
            document.getElementById('primary_color_text').value = e.target.value;
            document.getElementById('preview_primary').style.backgroundColor = e.target.value;
        });

        document.getElementById('secondary_color').addEventListener('input', function(e) {
            document.getElementById('secondary_color_text').value = e.target.value;
            document.getElementById('preview_secondary').style.backgroundColor = e.target.value;
        });
    </script>
</x-app-layout>
