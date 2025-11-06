<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('shop.create');
        }

        $customers = Customer::where('shop_id', $shop->id)
            ->latest()
            ->paginate(20);

        return view('customers.index', compact('customers', 'shop'));
    }

    public function create()
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('shop.create');
        }

        return view('customers.create', compact('shop'));
    }

    public function store(Request $request)
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('shop.create');
        }

        $validated = $request->validate([
            'code' => 'nullable|string|max:50|unique:customers,code,NULL,id,shop_id,' . $shop->id,
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'line_id' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'tax_id' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $validated['shop_id'] = $shop->id;

        // Auto-generate code if not provided
        if (empty($validated['code'])) {
            $lastCustomer = Customer::where('shop_id', $shop->id)
                ->orderBy('id', 'desc')
                ->first();

            $number = $lastCustomer ? (int)substr($lastCustomer->code, 4) + 1 : 1;
            $validated['code'] = 'CUST' . str_pad($number, 5, '0', STR_PAD_LEFT);
        }

        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'เพิ่มลูกค้าเรียบร้อยแล้ว');
    }

    public function show(Customer $customer)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $customer->shop_id !== $shop->id) {
            abort(403);
        }

        $customer->load(['quotations', 'invoices', 'receipts']);

        return view('customers.show', compact('customer', 'shop'));
    }

    public function edit(Customer $customer)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $customer->shop_id !== $shop->id) {
            abort(403);
        }

        return view('customers.edit', compact('customer', 'shop'));
    }

    public function update(Request $request, Customer $customer)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $customer->shop_id !== $shop->id) {
            abort(403);
        }

        $validated = $request->validate([
            'code' => 'nullable|string|max:50|unique:customers,code,' . $customer->id . ',id,shop_id,' . $shop->id,
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'line_id' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'tax_id' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'อัปเดตข้อมูลลูกค้าเรียบร้อยแล้ว');
    }

    public function destroy(Customer $customer)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $customer->shop_id !== $shop->id) {
            abort(403);
        }

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'ลบลูกค้าเรียบร้อยแล้ว');
    }
}
