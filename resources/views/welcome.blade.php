<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - ระบบใบเสนอราคา ใบแจ้งหนี้ ออนไลน์</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gradient-to-br from-blue-50 to-indigo-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-primary-600">Invoice SAAS</h1>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-primary-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary-600">เข้าสู่ระบบ</a>
                        <a href="{{ route('register') }}" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700">ลงทะเบียนฟรี</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-5xl font-extrabold text-gray-900 sm:text-6xl">
                    จัดการเอกสารธุรกิจ
                    <span class="text-primary-600">ง่ายและรวดเร็ว</span>
                </h1>
                <p class="mt-6 text-xl text-gray-600 max-w-3xl mx-auto">
                    ระบบใบเสนอราคา ใบแจ้งหนี้ ใบเสร็จรับเงิน ออนไลน์ที่ออกแบบมาสำหรับธุรกิจขนาดเล็ก
                    พร้อมส่งเอกสารผ่าน LINE และรับชำระเงินด้วย QR Code
                </p>
                <div class="mt-10 flex justify-center space-x-4">
                    <a href="{{ route('register') }}" class="bg-primary-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-primary-700 shadow-lg">
                        เริ่มใช้งานฟรี
                    </a>
                    <a href="#features" class="bg-white text-primary-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-50 shadow-lg border-2 border-primary-600">
                        ดูฟีเจอร์
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900">ฟีเจอร์ครบครัน</h2>
                <p class="mt-4 text-xl text-gray-600">ทุกสิ่งที่คุณต้องการสำหรับจัดการเอกสารธุรกิจ</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-6 border rounded-xl hover:shadow-xl transition">
                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">ใบเสนอราคา</h3>
                    <p class="text-gray-600">สร้างใบเสนอราคาสวยงาม ส่งให้ลูกค้าได้ทันที</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-6 border rounded-xl hover:shadow-xl transition">
                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">ใบแจ้งหนี้</h3>
                    <p class="text-gray-600">จัดการใบแจ้งหนี้ ติดตามการชำระเงิน</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-6 border rounded-xl hover:shadow-xl transition">
                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">ใบเสร็จรับเงิน</h3>
                    <p class="text-gray-600">ออกใบเสร็จอัตโนมัติเมื่อรับชำระเงิน</p>
                </div>

                <!-- Feature 4 -->
                <div class="p-6 border rounded-xl hover:shadow-xl transition">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">ส่งผ่าน LINE</h3>
                    <p class="text-gray-600">ส่งเอกสารให้ลูกค้าผ่าน LINE ได้ทันที</p>
                </div>

                <!-- Feature 5 -->
                <div class="p-6 border rounded-xl hover:shadow-xl transition">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">QR Code ชำระเงิน</h3>
                    <p class="text-gray-600">สร้าง QR PromptPay สำหรับรับเงินจากลูกค้า</p>
                </div>

                <!-- Feature 6 -->
                <div class="p-6 border rounded-xl hover:shadow-xl transition">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">ปรับแต่งเอกสาร</h3>
                    <p class="text-gray-600">เพิ่ม Logo สี และฟอนต์ตามแบบฉบับของคุณ</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-primary-600">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-4xl font-bold text-white mb-6">พร้อมเริ่มต้นแล้วหรือยัง?</h2>
            <p class="text-xl text-blue-100 mb-8">ลงทะเบียนฟรีวันนี้ ไม่ต้องใช้บัตรเครดิต</p>
            <a href="{{ route('register') }}" class="inline-block bg-white text-primary-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-100 shadow-lg">
                เริ่มใช้งานฟรีตอนนี้
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p>&copy; 2025 Invoice SAAS. สงวนลิขสิทธิ์.</p>
            </div>
        </div>
    </footer>
</body>
</html>
