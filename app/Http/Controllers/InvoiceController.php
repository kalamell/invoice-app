<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Quotation;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('shop.create');
        }

        $invoices = Invoice::where('shop_id', $shop->id)
            ->with('customer')
            ->latest()
            ->paginate(20);

        return view('invoices.index', compact('invoices', 'shop'));
    }

    public function create(Request $request)
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('shop.create');
        }

        $customers = Customer::where('shop_id', $shop->id)
            ->orderBy('name')
            ->get();

        // Check if creating from quotation
        $quotation = null;
        if ($request->has('quotation_id')) {
            $quotation = Quotation::where('shop_id', $shop->id)
                ->where('id', $request->quotation_id)
                ->with('items')
                ->first();
        }

        return view('invoices.create', compact('shop', 'customers', 'quotation'));
    }

    public function store(Request $request)
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('shop.create');
        }

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'quotation_id' => 'nullable|exists:quotations,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'status' => 'required|in:draft,sent,partial,paid,overdue,cancelled',
            'paid_amount' => 'nullable|numeric|min:0',
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

        // Verify quotation if provided
        if (!empty($validated['quotation_id'])) {
            $quotation = Quotation::findOrFail($validated['quotation_id']);
            if ($quotation->shop_id !== $shop->id) {
                abort(403);
            }
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

        // Create invoice
        $invoice = Invoice::create([
            'shop_id' => $shop->id,
            'customer_id' => $validated['customer_id'],
            'quotation_id' => $validated['quotation_id'] ?? null,
            'document_number' => $documentNumber,
            'issue_date' => $validated['issue_date'],
            'due_date' => $validated['due_date'],
            'status' => $validated['status'],
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'discount' => 0,
            'total' => $total,
            'paid_amount' => $validated['paid_amount'] ?? 0,
            'notes' => $validated['notes'] ?? null,
            'terms' => $validated['terms'] ?? null,
        ]);

        // Create items
        foreach ($validated['items'] as $index => $item) {
            $itemTotal = ($item['quantity'] * $item['unit_price']) - ($item['discount'] ?? 0);

            $invoice->items()->create([
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'discount' => $item['discount'] ?? 0,
                'total' => $itemTotal,
                'sort_order' => $index,
            ]);
        }

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'สร้างใบแจ้งหนี้เรียบร้อยแล้ว');
    }

    public function show(Invoice $invoice)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $invoice->shop_id !== $shop->id) {
            abort(403);
        }

        $invoice->load(['customer', 'items', 'quotation', 'receipts']);

        return view('invoices.show', compact('invoice', 'shop'));
    }

    public function edit(Invoice $invoice)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $invoice->shop_id !== $shop->id) {
            abort(403);
        }

        $customers = Customer::where('shop_id', $shop->id)
            ->orderBy('name')
            ->get();

        $invoice->load('items');

        return view('invoices.edit', compact('invoice', 'shop', 'customers'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $invoice->shop_id !== $shop->id) {
            abort(403);
        }

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'status' => 'required|in:draft,sent,partial,paid,overdue,cancelled',
            'paid_amount' => 'nullable|numeric|min:0',
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

        // Update invoice
        $invoice->update([
            'customer_id' => $validated['customer_id'],
            'issue_date' => $validated['issue_date'],
            'due_date' => $validated['due_date'],
            'status' => $validated['status'],
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total' => $total,
            'paid_amount' => $validated['paid_amount'] ?? 0,
            'notes' => $validated['notes'] ?? null,
            'terms' => $validated['terms'] ?? null,
        ]);

        // Delete old items and create new ones
        $invoice->items()->delete();

        foreach ($validated['items'] as $index => $item) {
            $itemTotal = ($item['quantity'] * $item['unit_price']) - ($item['discount'] ?? 0);

            $invoice->items()->create([
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'discount' => $item['discount'] ?? 0,
                'total' => $itemTotal,
                'sort_order' => $index,
            ]);
        }

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'อัปเดตใบแจ้งหนี้เรียบร้อยแล้ว');
    }

    public function destroy(Invoice $invoice)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $invoice->shop_id !== $shop->id) {
            abort(403);
        }

        $invoice->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'ลบใบแจ้งหนี้เรียบร้อยแล้ว');
    }
}
