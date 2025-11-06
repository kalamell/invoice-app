<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total statistics
        $totalShops = Shop::count();
        $totalUsers = User::count();
        $totalSubscriptions = Subscription::count();
        $activeShops = Shop::where('is_active', true)->count();
        $inactiveShops = Shop::where('is_active', false)->count();

        // Revenue this month
        $revenueThisMonth = Subscription::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        // Active subscriptions
        $activeSubscriptions = Subscription::where('status', 'active')
            ->where('end_date', '>=', now())
            ->count();

        // Recent activities (last 10 shops)
        $recentShops = Shop::with('user')
            ->latest()
            ->limit(10)
            ->get();

        // Monthly growth data for chart (last 6 months)
        $monthlyGrowth = Shop::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Monthly revenue data for chart (last 6 months)
        $monthlyRevenue = Subscription::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(amount) as revenue')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'totalShops',
            'totalUsers',
            'totalSubscriptions',
            'activeShops',
            'inactiveShops',
            'revenueThisMonth',
            'activeSubscriptions',
            'recentShops',
            'monthlyGrowth',
            'monthlyRevenue'
        ));
    }
}
