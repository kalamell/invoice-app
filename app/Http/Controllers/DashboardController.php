<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Quotation;
use App\Models\Receipt;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $shop = $user->shop;

        // ถ้ายังไม่มีร้านค้า ให้ redirect ไปสร้าง
        if (!$shop) {
            return redirect()->route('shop.create');
        }

        // สถิติต่างๆ
        $stats = [
            'customers_count' => Customer::where('shop_id', $shop->id)->count(),
            'quotations_count' => Quotation::where('shop_id', $shop->id)->count(),
            'invoices_count' => Invoice::where('shop_id', $shop->id)->count(),
            'receipts_count' => Receipt::where('shop_id', $shop->id)->count(),

            // เอกสารล่าสุด
            'recent_quotations' => Quotation::where('shop_id', $shop->id)
                ->with('customer')
                ->latest()
                ->take(5)
                ->get(),

            'recent_invoices' => Invoice::where('shop_id', $shop->id)
                ->with('customer')
                ->latest()
                ->take(5)
                ->get(),

            // ยอดเงินรวม
            'total_invoices_amount' => Invoice::where('shop_id', $shop->id)
                ->where('status', '!=', 'cancelled')
                ->sum('total'),

            'total_paid_amount' => Invoice::where('shop_id', $shop->id)
                ->where('status', 'paid')
                ->sum('total'),

            'total_pending_amount' => Invoice::where('shop_id', $shop->id)
                ->whereIn('status', ['draft', 'sent', 'partial'])
                ->sum('total'),
        ];

        return view('dashboard', compact('shop', 'stats'));
    }
}
