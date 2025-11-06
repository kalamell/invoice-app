<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    public function index()
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('shop.create');
        }

        $receipts = Receipt::where('shop_id', $shop->id)
            ->with(['customer', 'invoice'])
            ->latest()
            ->paginate(20);

        return view('receipts.index', compact('receipts', 'shop'));
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

        // Check if creating from invoice
        $invoice = null;
        if ($request->has('invoice_id')) {
            $invoice = Invoice::where('shop_id', $shop->id)
                ->where('id', $request->invoice_id)
                ->with('customer')
                ->first();
        }

        return view('receipts.create', compact('shop', 'customers', 'invoice'));
    }

    public function store(Request $request)
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('shop.create');
        }

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_id' => 'nullable|exists:invoices,id',
            'issue_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,cheque,credit_card,promptpay',
            'payment_reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        // Verify customer belongs to shop
        $customer = Customer::findOrFail($validated['customer_id']);
        if ($customer->shop_id !== $shop->id) {
            abort(403);
        }

        // Verify invoice if provided
        $invoice = null;
        if (!empty($validated['invoice_id'])) {
            $invoice = Invoice::findOrFail($validated['invoice_id']);
            if ($invoice->shop_id !== $shop->id) {
                abort(403);
            }
        }

        // Generate document number
        $settings = $shop->settings;
        $documentNumber = $settings->getNextDocumentNumber();

        // Create receipt
        $receipt = Receipt::create([
            'shop_id' => $shop->id,
            'customer_id' => $validated['customer_id'],
            'invoice_id' => $validated['invoice_id'] ?? null,
            'document_number' => $documentNumber,
            'issue_date' => $validated['issue_date'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'payment_reference' => $validated['payment_reference'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Update invoice paid amount if linked
        if ($invoice) {
            $invoice->paid_amount = ($invoice->paid_amount ?? 0) + $validated['amount'];

            // Update invoice status
            if ($invoice->paid_amount >= $invoice->total) {
                $invoice->status = 'paid';
            } elseif ($invoice->paid_amount > 0) {
                $invoice->status = 'partial';
            }

            $invoice->save();
        }

        return redirect()->route('receipts.show', $receipt)
            ->with('success', 'สร้างใบเสร็จรับเงินเรียบร้อยแล้ว');
    }

    public function show(Receipt $receipt)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $receipt->shop_id !== $shop->id) {
            abort(403);
        }

        $receipt->load(['customer', 'invoice']);

        return view('receipts.show', compact('receipt', 'shop'));
    }

    public function edit(Receipt $receipt)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $receipt->shop_id !== $shop->id) {
            abort(403);
        }

        $customers = Customer::where('shop_id', $shop->id)
            ->orderBy('name')
            ->get();

        $invoices = Invoice::where('shop_id', $shop->id)
            ->where('customer_id', $receipt->customer_id)
            ->get();

        return view('receipts.edit', compact('receipt', 'shop', 'customers', 'invoices'));
    }

    public function update(Request $request, Receipt $receipt)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $receipt->shop_id !== $shop->id) {
            abort(403);
        }

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_id' => 'nullable|exists:invoices,id',
            'issue_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,cheque,credit_card,promptpay',
            'payment_reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        // Verify customer belongs to shop
        $customer = Customer::findOrFail($validated['customer_id']);
        if ($customer->shop_id !== $shop->id) {
            abort(403);
        }

        // Verify invoice if provided
        if (!empty($validated['invoice_id'])) {
            $invoice = Invoice::findOrFail($validated['invoice_id']);
            if ($invoice->shop_id !== $shop->id) {
                abort(403);
            }
        }

        // Update old invoice paid amount if changed
        if ($receipt->invoice_id && $receipt->invoice_id !== $validated['invoice_id']) {
            $oldInvoice = Invoice::find($receipt->invoice_id);
            if ($oldInvoice) {
                $oldInvoice->paid_amount = max(0, ($oldInvoice->paid_amount ?? 0) - $receipt->amount);

                // Update old invoice status
                if ($oldInvoice->paid_amount >= $oldInvoice->total) {
                    $oldInvoice->status = 'paid';
                } elseif ($oldInvoice->paid_amount > 0) {
                    $oldInvoice->status = 'partial';
                } else {
                    $oldInvoice->status = 'sent';
                }

                $oldInvoice->save();
            }
        }

        // Update receipt
        $receipt->update([
            'customer_id' => $validated['customer_id'],
            'invoice_id' => $validated['invoice_id'] ?? null,
            'issue_date' => $validated['issue_date'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'payment_reference' => $validated['payment_reference'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Update new invoice paid amount
        if ($receipt->invoice_id) {
            $invoice = Invoice::find($receipt->invoice_id);
            if ($invoice) {
                $invoice->paid_amount = ($invoice->paid_amount ?? 0) + $validated['amount'];

                // Update invoice status
                if ($invoice->paid_amount >= $invoice->total) {
                    $invoice->status = 'paid';
                } elseif ($invoice->paid_amount > 0) {
                    $invoice->status = 'partial';
                }

                $invoice->save();
            }
        }

        return redirect()->route('receipts.show', $receipt)
            ->with('success', 'อัปเดตใบเสร็จรับเงินเรียบร้อยแล้ว');
    }

    public function destroy(Receipt $receipt)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $receipt->shop_id !== $shop->id) {
            abort(403);
        }

        // Update invoice paid amount if linked
        if ($receipt->invoice_id) {
            $invoice = Invoice::find($receipt->invoice_id);
            if ($invoice) {
                $invoice->paid_amount = max(0, ($invoice->paid_amount ?? 0) - $receipt->amount);

                // Update invoice status
                if ($invoice->paid_amount >= $invoice->total) {
                    $invoice->status = 'paid';
                } elseif ($invoice->paid_amount > 0) {
                    $invoice->status = 'partial';
                } else {
                    $invoice->status = 'sent';
                }

                $invoice->save();
            }
        }

        $receipt->delete();

        return redirect()->route('receipts.index')
            ->with('success', 'ลบใบเสร็จรับเงินเรียบร้อยแล้ว');
    }

    public function exportPdf(Receipt $receipt)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $receipt->shop_id !== $shop->id) {
            abort(403);
        }

        $receipt->load('customer');

        $pdf = Pdf::loadView('receipts.pdf', compact('receipt', 'shop'))
            ->setPaper('a4', 'portrait');

        // Load custom fonts for Thai support
        $pdf->getDomPDF()->getOptions()->set('isRemoteEnabled', true);
        $pdf->getDomPDF()->getOptions()->set('defaultFont', 'freeserif');

        return $pdf->download('ใบเสร็จรับเงิน-' . $receipt->document_number . '.pdf');
    }
}
