<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPlanController extends Controller
{
    public function index()
    {
        $plans = Plan::withCount('subscriptions')
            ->orderBy('sort_order')
            ->get();

        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'max_documents' => 'nullable|integer|min:0',
            'max_customers' => 'nullable|integer|min:0',
            'can_send_line' => 'boolean',
            'can_customize_template' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['can_send_line'] = $request->has('can_send_line');
        $validated['can_customize_template'] = $request->has('can_customize_template');
        $validated['is_active'] = $request->has('is_active');

        Plan::create($validated);

        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully.');
    }

    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'max_documents' => 'nullable|integer|min:0',
            'max_customers' => 'nullable|integer|min:0',
            'can_send_line' => 'boolean',
            'can_customize_template' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['can_send_line'] = $request->has('can_send_line');
        $validated['can_customize_template'] = $request->has('can_customize_template');
        $validated['is_active'] = $request->has('is_active');

        $plan->update($validated);

        return redirect()->route('admin.plans.index')->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan)
    {
        // Check if plan has active subscriptions
        if ($plan->subscriptions()->where('status', 'active')->exists()) {
            return redirect()->back()->with('error', 'Cannot delete plan with active subscriptions.');
        }

        $plan->delete();

        return redirect()->route('admin.plans.index')->with('success', 'Plan deleted successfully.');
    }
}
