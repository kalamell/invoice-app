<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('แก้ไขข้อมูลร้านค้า') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('shop.update') }}">
                        @csrf
                        @method('PATCH')

                        <!-- Shop Name -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('ชื่อร้านค้า')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $shop->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('คำอธิบาย')" />
                            <textarea id="description" name="description" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ old('description', $shop->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <x-input-label for="email" :value="__('อีเมล')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $shop->email)" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Phone -->
                        <div class="mb-4">
                            <x-input-label for="phone" :value="__('เบอร์โทรศัพท์')" />
                            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $shop->phone)" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <!-- Address -->
                        <div class="mb-4">
                            <x-input-label for="address" :value="__('ที่อยู่')" />
                            <textarea id="address" name="address" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ old('address', $shop->address) }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <!-- Tax ID -->
                        <div class="mb-4">
                            <x-input-label for="tax_id" :value="__('เลขผู้เสียภาษี')" />
                            <x-text-input id="tax_id" class="block mt-1 w-full" type="text" name="tax_id" :value="old('tax_id', $shop->tax_id)" />
                            <x-input-error :messages="$errors->get('tax_id')" class="mt-2" />
                        </div>

                        <!-- Website -->
                        <div class="mb-6">
                            <x-input-label for="website" :value="__('เว็บไซต์')" />
                            <x-text-input id="website" class="block mt-1 w-full" type="url" name="website" :value="old('website', $shop->website)" />
                            <x-input-error :messages="$errors->get('website')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
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
