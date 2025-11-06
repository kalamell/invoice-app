<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('shop');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load([
            'shop.activeSubscription.plan',
            'shop.subscriptions' => function ($query) {
                $query->latest()->limit(5);
            }
        ]);

        return view('admin.users.show', compact('user'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,shop_owner'
        ]);

        // Prevent users from removing their own admin role
        if ($user->id === auth()->id() && $request->role !== 'admin') {
            return redirect()->back()->with('error', 'You cannot remove your own admin role.');
        }

        $user->update([
            'role' => $request->role
        ]);

        return redirect()->back()->with('success', 'User role has been updated successfully.');
    }
}
