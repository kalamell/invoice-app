<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class AdminSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscription::with(['shop.user', 'plan']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('shop', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('plan', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by plan
        if ($request->filled('plan_id')) {
            $query->where('plan_id', $request->plan_id);
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $subscriptions = $query->paginate(15)->withQueryString();

        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function show(Subscription $subscription)
    {
        $subscription->load([
            'shop.user',
            'plan'
        ]);

        return view('admin.subscriptions.show', compact('subscription'));
    }
}
