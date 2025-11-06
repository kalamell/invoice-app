<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - ระบบใบเสนอราคา ใบแจ้งหนี้ ออนไลน์</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        .gradient-animated {
            background: linear-gradient(-45deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 75%, #00f2fe 100%);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="antialiased">
    <!-- Animated Background -->
    <div class="fixed inset-0 -z-10 gradient-animated"></div>
    <div class="fixed inset-0 -z-10 bg-white/30"></div>

    <!-- Navigation -->
    <nav class="glass-effect sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Invoice SAAS</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-purple-600 font-medium transition">แดชบอร์ด</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-purple-600 font-medium transition">เข้าสู่ระบบ</a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl hover:shadow-2xl transform hover:scale-105 transition duration-300 font-semibold">
                            ลงทะเบียนฟรี
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative py-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="animate-fadeInUp">
                    <span class="inline-block px-4 py-2 bg-white/80 backdrop-blur-sm rounded-full text-purple-600 font-semibold mb-6 shadow-lg">
                        🚀 ระบบจัดการเอกสารอัจฉริยะ
                    </span>
                </div>
                <h1 class="text-6xl md:text-7xl font-extrabold text-gray-900 mb-6 animate-fadeInUp" style="animation-delay: 0.1s">
                    จัดการเอกสารธุรกิจ
                    <span class="block bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                        ง่ายและรวดเร็ว
                    </span>
                </h1>
                <p class="mt-6 text-2xl text-gray-700 max-w-3xl mx-auto animate-fadeInUp leading-relaxed" style="animation-delay: 0.2s">
                    ระบบใบเสนอราคา ใบแจ้งหนี้ ใบเสร็จรับเงิน ที่ออกแบบมาสำหรับธุรกิจ SME
                    <br>
                    <span class="text-purple-600 font-semibold">พร้อมส่งผ่าน LINE และรับชำระเงินด้วย QR Code</span>
                </p>
                <div class="mt-12 flex flex-col sm:flex-row justify-center gap-4 animate-fadeInUp" style="animation-delay: 0.3s">
                    <a href="{{ route('register') }}" class="group relative inline-flex items-center justify-center px-10 py-5 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-lg font-bold rounded-2xl hover:shadow-2xl transform hover:scale-105 transition duration-300 overflow-hidden">
                        <span class="relative z-10">เริ่มใช้งานฟรีเลย</span>
                        <svg class="relative z-10 w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    <a href="#features" class="inline-flex items-center justify-center px-10 py-5 bg-white/90 backdrop-blur-sm text-purple-600 text-lg font-bold rounded-2xl hover:shadow-2xl transform hover:scale-105 transition duration-300 border-2 border-purple-200">
                        ดูฟีเจอร์ทั้งหมด
                    </a>
                </div>

                <!-- Stats -->
                <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
                    <div class="glass-effect p-6 rounded-2xl shadow-xl transform hover:scale-105 transition">
                        <div class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">1,000+</div>
                        <div class="text-gray-600 font-medium mt-2">ธุรกิจที่ไว้วางใจ</div>
                    </div>
                    <div class="glass-effect p-6 rounded-2xl shadow-xl transform hover:scale-105 transition">
                        <div class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">50,000+</div>
                        <div class="text-gray-600 font-medium mt-2">เอกสารที่สร้าง</div>
                    </div>
                    <div class="glass-effect p-6 rounded-2xl shadow-xl transform hover:scale-105 transition">
                        <div class="text-4xl font-bold bg-gradient-to-r from-pink-600 to-red-600 bg-clip-text text-transparent">99.9%</div>
                        <div class="text-gray-600 font-medium mt-2">ความพึงพอใจ</div>
                    </div>
                    <div class="glass-effect p-6 rounded-2xl shadow-xl transform hover:scale-105 transition">
                        <div class="text-4xl font-bold bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent">24/7</div>
                        <div class="text-gray-600 font-medium mt-2">ใช้งานได้ทุกเวลา</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 relative">
        <div class="absolute inset-0 bg-white/50 backdrop-blur-sm"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center mb-20">
                <span class="inline-block px-4 py-2 bg-purple-100 rounded-full text-purple-600 font-semibold mb-4">
                    ฟีเจอร์เด่น
                </span>
                <h2 class="text-5xl font-bold text-gray-900 mb-4">ครบครันทุกฟังก์ชัน</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    เครื่องมือครบครันที่ออกแบบมาเพื่อธุรกิจของคุณ
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group glass-effect p-8 rounded-3xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-900">ใบเสนอราคา</h3>
                    <p class="text-gray-600 leading-relaxed">สร้างใบเสนอราคาสวยงามและมืออาชีพ ส่งให้ลูกค้าได้ทันที แปลงเป็นใบแจ้งหนี้ได้ด้วยคลิกเดียว</p>
                </div>

                <!-- Feature 2 -->
                <div class="group glass-effect p-8 rounded-3xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-900">ใบแจ้งหนี้</h3>
                    <p class="text-gray-600 leading-relaxed">จัดการใบแจ้งหนี้อย่างมืออาชีพ ติดตามสถานะการชำระเงิน และแจ้งเตือนอัตโนมัติ</p>
                </div>

                <!-- Feature 3 -->
                <div class="group glass-effect p-8 rounded-3xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-900">ใบเสร็จรับเงิน</h3>
                    <p class="text-gray-600 leading-relaxed">ออกใบเสร็จอัตโนมัติเมื่อรับชำระเงิน พร้อมอัปเดตสถานะทันที</p>
                </div>

                <!-- Feature 4 -->
                <div class="group glass-effect p-8 rounded-3xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-teal-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-900">ส่งผ่าน LINE</h3>
                    <p class="text-gray-600 leading-relaxed">ส่งเอกสารให้ลูกค้าผ่าน LINE ได้ทันที สะดวก รวดเร็ว ไม่ต้องพิมพ์</p>
                </div>

                <!-- Feature 5 -->
                <div class="group glass-effect p-8 rounded-3xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-900">QR Code ชำระเงิน</h3>
                    <p class="text-gray-600 leading-relaxed">สร้าง QR PromptPay พร้อมยอดเงินอัตโนมัติ ลูกค้าสแกนจ่ายได้เลย</p>
                </div>

                <!-- Feature 6 -->
                <div class="group glass-effect p-8 rounded-3xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-900">ปรับแต่งได้เอง</h3>
                    <p class="text-gray-600 leading-relaxed">เพิ่ม Logo สี ฟอนต์ และรายละเอียดต่างๆ ให้ตรงกับแบรนด์ธุรกิจของคุณ</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative py-32 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600"></div>
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="max-w-4xl mx-auto text-center px-4 relative z-10">
            <h2 class="text-5xl md:text-6xl font-bold text-white mb-6 animate-fadeInUp">พร้อมเริ่มต้นแล้วหรือยัง?</h2>
            <p class="text-2xl text-white/90 mb-10 animate-fadeInUp" style="animation-delay: 0.1s">
                เริ่มใช้งานฟรีวันนี้ ไม่ต้องใช้บัตรเครดิต ใช้งานได้ทันที
            </p>
            <div class="animate-fadeInUp" style="animation-delay: 0.2s">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-12 py-6 bg-white text-purple-600 text-xl font-bold rounded-2xl hover:shadow-2xl transform hover:scale-105 transition duration-300">
                    เริ่มใช้งานฟรีตอนนี้
                    <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
            <p class="mt-6 text-white/80">✅ ไม่ต้องผูกบัตรเครดิต &nbsp;&nbsp; ✅ ยกเลิกได้ทุกเมื่อ &nbsp;&nbsp; ✅ ใช้งานได้ทันที</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center space-x-3 mb-4">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white">Invoice SAAS</span>
                </div>
                <p class="text-gray-500">&copy; 2025 Invoice SAAS. สงวนลิขสิทธิ์ทั้งหมด.</p>
                <div class="mt-4 flex justify-center space-x-6">
                    <a href="#" class="hover:text-white transition">เกี่ยวกับเรา</a>
                    <a href="#" class="hover:text-white transition">นโยบายความเป็นส่วนตัว</a>
                    <a href="#" class="hover:text-white transition">เงื่อนไขการใช้งาน</a>
                    <a href="#" class="hover:text-white transition">ติดต่อเรา</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
