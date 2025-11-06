<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('เพิ่มลูกค้า') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('customers.store') }}">
                        @csrf

                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Code -->
                            <div class="mb-4">
                                <x-input-label for="code" :value="__('รหัสลูกค้า')" />
                                <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code')" placeholder="เว้นว่างเพื่อสร้างอัตโนมัติ" />
                                <x-input-error :messages="$errors->get('code')" class="mt-2" />
                            </div>

                            <!-- Name -->
                            <div class="mb-4">
                                <x-input-label for="name" :value="__('ชื่อลูกค้า *')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Email -->
                            <div class="mb-4">
                                <x-input-label for="email" :value="__('อีเมล')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Phone -->
                            <div class="mb-4">
                                <x-input-label for="phone" :value="__('เบอร์โทรศัพท์')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                        </div>

                        <!-- LINE ID -->
                        <div class="mb-4">
                            <x-input-label for="line_id" :value="__('LINE ID')" />
                            <x-text-input id="line_id" class="block mt-1 w-full" type="text" name="line_id" :value="old('line_id')" />
                            <p class="text-xs text-gray-500 mt-1">ใช้สำหรับส่งเอกสารผ่าน LINE</p>
                            <x-input-error :messages="$errors->get('line_id')" class="mt-2" />
                        </div>

                        <!-- Address -->
                        <div class="mb-4">
                            <x-input-label for="address" :value="__('ที่อยู่')" />
                            <textarea id="address" name="address" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ old('address') }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <!-- Tax ID -->
                        <div class="mb-4">
                            <x-input-label for="tax_id" :value="__('เลขผู้เสียภาษี')" />
                            <x-text-input id="tax_id" class="block mt-1 w-full" type="text" name="tax_id" :value="old('tax_id')" />
                            <x-input-error :messages="$errors->get('tax_id')" class="mt-2" />
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <x-input-label for="notes" :value="__('หมายเหตุ')" />
                            <textarea id="notes" name="notes" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('customers.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                                ← กลับ
                            </a>
                            <x-primary-button class="ml-4">
                                {{ __('บันทึก') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
