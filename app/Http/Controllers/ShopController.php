<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\ShopSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    public function create()
    {
        // ถ้ามีร้านค้าแล้ว ให้ redirect ไปที่ dashboard
        if (auth()->user()->shop) {
            return redirect()->route('dashboard');
        }

        return view('shop.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'tax_id' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
        ]);

        // สร้าง slug จากชื่อร้าน
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;

        // ตรวจสอบว่า slug ซ้ำหรือไม่
        while (Shop::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // สร้างร้านค้า
        $shop = Shop::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'tax_id' => $validated['tax_id'] ?? null,
            'website' => $validated['website'] ?? null,
            'is_active' => true,
        ]);

        // สร้างการตั้งค่าเริ่มต้นสำหรับร้านค้า
        ShopSetting::create([
            'shop_id' => $shop->id,
            'document_prefix' => 'INV',
            'document_number' => 1,
            'primary_color' => '#0ea5e9',
            'secondary_color' => '#0369a1',
            'font_family' => 'Sarabun',
            'show_tax' => true,
            'tax_rate' => 7.00,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'สร้างร้านค้าเรียบร้อยแล้ว!');
    }

    public function edit()
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('shop.create');
        }

        return view('shop.edit', compact('shop'));
    }

    public function update(Request $request)
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('shop.create');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'tax_id' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
        ]);

        $shop->update($validated);

        return redirect()->route('shop.edit')
            ->with('success', 'อัปเดตข้อมูลร้านค้าเรียบร้อยแล้ว!');
    }

    public function settings()
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('shop.create');
        }

        $settings = $shop->settings;

        return view('shop.settings', compact('shop', 'settings'));
    }

    public function updateSettings(Request $request)
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('shop.create');
        }

        $validated = $request->validate([
            'document_prefix' => 'required|string|max:10',
            'primary_color' => 'required|string|max:7',
            'secondary_color' => 'required|string|max:7',
            'font_family' => 'required|string|max:50',
            'footer_text' => 'nullable|string',
            'show_tax' => 'boolean',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'promptpay_id' => 'nullable|string|max:20',
            'promptpay_name' => 'nullable|string|max:255',
        ]);

        $shop->settings->update($validated);

        return redirect()->route('shop.settings')
            ->with('success', 'อัปเดตการตั้งค่าเรียบร้อยแล้ว!');
    }
}
