<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class QuotationController extends Controller
{
    public function index()
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('shop.create');
        }

        $quotations = Quotation::where('shop_id', $shop->id)
            ->with('customer')
            ->latest()
            ->paginate(20);

        return view('quotations.index', compact('quotations', 'shop'));
    }

    public function create()
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('shop.create');
        }

        $customers = Customer::where('shop_id', $shop->id)
            ->orderBy('name')
            ->get();

        return view('quotations.create', compact('shop', 'customers'));
    }

    public function store(Request $request)
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('shop.create');
        }

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'issue_date' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:issue_date',
            'status' => 'required|in:draft,sent,accepted,rejected',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
        ]);

        // Verify customer belongs to shop
        $customer = Customer::findOrFail($validated['customer_id']);
        if ($customer->shop_id !== $shop->id) {
            abort(403);
        }

        // Generate document number
        $settings = $shop->settings;
        $documentNumber = $settings->getNextDocumentNumber();

        // Calculate totals
        $subtotal = 0;
        foreach ($validated['items'] as $item) {
            $itemTotal = ($item['quantity'] * $item['unit_price']) - ($item['discount'] ?? 0);
            $subtotal += $itemTotal;
        }

        $taxAmount = 0;
        if ($settings->show_tax) {
            $taxAmount = $subtotal * ($settings->tax_rate / 100);
        }

        $total = $subtotal + $taxAmount;

        // Create quotation
        $quotation = Quotation::create([
            'shop_id' => $shop->id,
            'customer_id' => $validated['customer_id'],
            'document_number' => $documentNumber,
            'issue_date' => $validated['issue_date'],
            'valid_until' => $validated['valid_until'],
            'status' => $validated['status'],
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'discount' => 0,
            'total' => $total,
            'notes' => $validated['notes'] ?? null,
            'terms' => $validated['terms'] ?? null,
        ]);

        // Create items
        foreach ($validated['items'] as $index => $item) {
            $itemTotal = ($item['quantity'] * $item['unit_price']) - ($item['discount'] ?? 0);

            $quotation->items()->create([
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'discount' => $item['discount'] ?? 0,
                'total' => $itemTotal,
                'sort_order' => $index,
            ]);
        }

        return redirect()->route('quotations.show', $quotation)
            ->with('success', 'สร้างใบเสนอราคาเรียบร้อยแล้ว');
    }

    public function show(Quotation $quotation)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $quotation->shop_id !== $shop->id) {
            abort(403);
        }

        $quotation->load(['customer', 'items']);

        return view('quotations.show', compact('quotation', 'shop'));
    }

    public function edit(Quotation $quotation)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $quotation->shop_id !== $shop->id) {
            abort(403);
        }

        $customers = Customer::where('shop_id', $shop->id)
            ->orderBy('name')
            ->get();

        $quotation->load('items');

        return view('quotations.edit', compact('quotation', 'shop', 'customers'));
    }

    public function update(Request $request, Quotation $quotation)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $quotation->shop_id !== $shop->id) {
            abort(403);
        }

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'issue_date' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:issue_date',
            'status' => 'required|in:draft,sent,accepted,rejected',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
        ]);

        // Verify customer belongs to shop
        $customer = Customer::findOrFail($validated['customer_id']);
        if ($customer->shop_id !== $shop->id) {
            abort(403);
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($validated['items'] as $item) {
            $itemTotal = ($item['quantity'] * $item['unit_price']) - ($item['discount'] ?? 0);
            $subtotal += $itemTotal;
        }

        $settings = $shop->settings;
        $taxAmount = 0;
        if ($settings->show_tax) {
            $taxAmount = $subtotal * ($settings->tax_rate / 100);
        }

        $total = $subtotal + $taxAmount;

        // Update quotation
        $quotation->update([
            'customer_id' => $validated['customer_id'],
            'issue_date' => $validated['issue_date'],
            'valid_until' => $validated['valid_until'],
            'status' => $validated['status'],
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total' => $total,
            'notes' => $validated['notes'] ?? null,
            'terms' => $validated['terms'] ?? null,
        ]);

        // Delete old items and create new ones
        $quotation->items()->delete();

        foreach ($validated['items'] as $index => $item) {
            $itemTotal = ($item['quantity'] * $item['unit_price']) - ($item['discount'] ?? 0);

            $quotation->items()->create([
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'discount' => $item['discount'] ?? 0,
                'total' => $itemTotal,
                'sort_order' => $index,
            ]);
        }

        return redirect()->route('quotations.show', $quotation)
            ->with('success', 'อัปเดตใบเสนอราคาเรียบร้อยแล้ว');
    }

    public function destroy(Quotation $quotation)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $quotation->shop_id !== $shop->id) {
            abort(403);
        }

        $quotation->delete();

        return redirect()->route('quotations.index')
            ->with('success', 'ลบใบเสนอราคาเรียบร้อยแล้ว');
    }

    public function exportPdf(Quotation $quotation)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $quotation->shop_id !== $shop->id) {
            abort(403);
        }

        $quotation->load(['customer', 'items']);

        $pdf = Pdf::loadView('quotations.pdf', compact('quotation', 'shop'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('ใบเสนอราคา-' . $quotation->document_number . '.pdf');
    }
}
