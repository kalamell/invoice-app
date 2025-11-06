<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class AdminShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Shop::with(['user', 'activeSubscription.plan']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $shops = $query->paginate(15)->withQueryString();

        return view('admin.shops.index', compact('shops'));
    }

    public function show(Shop $shop)
    {
        $shop->load([
            'user',
            'activeSubscription.plan',
            'subscriptions' => function ($query) {
                $query->latest()->limit(5);
            },
            'customers',
            'invoices',
            'quotations',
            'receipts'
        ]);

        // Statistics for this shop
        $stats = [
            'total_customers' => $shop->customers()->count(),
            'total_invoices' => $shop->invoices()->count(),
            'total_quotations' => $shop->quotations()->count(),
            'total_receipts' => $shop->receipts()->count(),
            'total_revenue' => $shop->invoices()->sum('total_amount'),
        ];

        return view('admin.shops.show', compact('shop', 'stats'));
    }

    public function suspend(Shop $shop)
    {
        $shop->update([
            'is_active' => !$shop->is_active
        ]);

        $status = $shop->is_active ? 'activated' : 'suspended';
        return redirect()->back()->with('success', "Shop has been {$status} successfully.");
    }

    public function destroy(Shop $shop)
    {
        $shop->delete();
        return redirect()->route('admin.shops.index')->with('success', 'Shop has been deleted successfully.');
    }
}
