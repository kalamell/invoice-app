# 🚀 คู่มือติดตั้ง Invoice SAAS

## ✅ สิ่งที่ต้องเตรียม

- PHP 8.4+
- Composer
- Node.js & NPM
- MySQL/MariaDB
- Git

## 📦 ขั้นตอนการติดตั้ง

### 1. Clone Repository

```bash
git clone <repository-url>
cd invoice-app
```

### 2. ติดตั้ง Dependencies

```bash
composer install
npm install
```

### 3. ตั้งค่า Environment

```bash
# คัดลอก .env.example
cp .env.example .env

# Generate Application Key
php artisan key:generate
```

### 4. ตั้งค่า Database

**สร้าง Database:**

```bash
# เข้า MySQL/MariaDB
mysql -u root -p

# สร้าง database
CREATE DATABASE invoice_saas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;
```

**แก้ไข .env:**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=invoice_saas
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Build Assets

```bash
# สำหรับ Development
npm run dev

# หรือ สำหรับ Production
npm run build
```

### 7. Start Server

```bash
php artisan serve
```

เปิดเบราว์เซอร์: **http://localhost:8000**

## 🎯 การใช้งานครั้งแรก

1. เข้าหน้าแรก → คลิก **"ลงทะเบียนฟรี"**
2. กรอก Email และ Password
3. Login เข้าสู่ระบบ
4. สร้างร้านค้า (กรอกชื่อร้าน, ที่อยู่, เลขผู้เสียภาษี)
5. เข้าสู่ Dashboard → เริ่มสร้างเอกสาร!

## ⚠️ การแก้ไขปัญหา

### ❌ Error: "No application encryption key"

```bash
php artisan key:generate
php artisan config:clear
```

### ❌ Error: "Connection refused (MySQL)"

**ตรวจสอบว่า MySQL/MariaDB ทำงานอยู่:**

```bash
# Ubuntu/Debian
sudo systemctl status mysql

# macOS
brew services list

# Start MySQL
sudo systemctl start mysql  # Linux
brew services start mysql    # macOS
```

**ตรวจสอบ credentials ใน .env:**
- ตรวจสอบ `DB_USERNAME` และ `DB_PASSWORD`
- ลอง login mysql ด้วย credentials เดียวกัน

### ❌ Error: "could not find driver (SQLite)"

ระบบต้องการ MySQL/MariaDB ไม่รองรับ SQLite ในขณะนี้

แก้ไข: ติดตั้ง MySQL/MariaDB ตามขั้นตอนข้างต้น

### ❌ Error: Migration Failed

```bash
# ลบ database เดิมและสร้างใหม่
mysql -u root -p
DROP DATABASE invoice_saas;
CREATE DATABASE invoice_saas;
exit;

# Run migrations ใหม่
php artisan migrate:fresh
```

## 🔧 การตั้งค่าเพิ่มเติม

### LINE Messaging API

1. สร้าง LINE Channel: https://developers.line.biz/
2. เพิ่มใน .env:

```env
LINE_CHANNEL_ACCESS_TOKEN=your_token_here
LINE_CHANNEL_SECRET=your_secret_here
```

### PromptPay QR Code

เพิ่มใน .env:

```env
PROMPTPAY_ID=0812345678
PROMPTPAY_NAME="ชื่อร้านค้าของคุณ"
```

## 📱 การใช้งานใน Production

```bash
# Build assets สำหรับ production
npm run build

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# ตั้งค่า .env
APP_ENV=production
APP_DEBUG=false
```

## 🆘 ต้องการความช่วยเหลือ?

- ตรวจสอบ logs: `storage/logs/laravel.log`
- เปิด Issue ใน GitHub
- ติดต่อทีมพัฒนา

---

**หมายเหตุ:** ระบบนี้พัฒนาสำหรับธุรกิจขนาดเล็กในประเทศไทย  
Made with ❤️ for Thai SMEs
