<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Models\Activity;
use App\Models\Customer;
use App\Models\Lead;

class ActivityController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $user  = auth()->user();
        $query = Activity::with(['user', 'customer', 'lead']);

        if ($user->isSalesStaff()) {
            $query->forUser($user->id);
        }

        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('lead_id')) {
            $query->where('lead_id', $request->lead_id);
        }

        $activities = $query->latest('activity_date')->paginate(20)->withQueryString();
        $types = Activity::TYPES;

        return view('activities.index', compact('activities', 'types'));
    }

    public function create(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();
        $types = Activity::TYPES;

        $customers = $user->isSalesStaff() ? Customer::assignedTo($user->id)->get() : Customer::all();

        $leads = $user->isSalesStaff() ? Lead::assignedTo($user->id)->active()->get() : Lead::active()->get();

        $selectedCustomerId = $request->query('customer_id');
        $selectedLeadId = $request->query('lead_id');

        return view('activities.create', compact('types','customers','leads','selectedCustomerId','selectedLeadId'));
    }

    public function store(StoreActivityRequest $request)
    {
        $validated = $request->validated();

        Activity::create($validated);

        if (!empty($validated['customer_id'])) {
            return redirect()->route('customers.show', $validated['customer_id'])->with('success', 'Activity logged successfully.');
        }

        return redirect()->route('leads.show', $validated['lead_id'])->with('success', 'Activity logged successfully.');
    }

    public function edit(\Illuminate\Http\Request $request, Activity $activity)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
 
        if (!$user->isAdmin() && $activity->user_id !== $user->id) {
            abort(403, 'You are not authorized to edit this activity.');
        }
 
        $types = Activity::TYPES;
 
        $customers = $user->isSalesStaff()
            ? Customer::assignedTo($user->id)->get()
            : Customer::all();
 
        $leads = $user->isSalesStaff()
            ? Lead::assignedTo($user->id)->active()->get()
            : Lead::active()->get();
 
        return view('activities.edit', compact('activity', 'types', 'customers', 'leads'));
    }

    public function update(\Illuminate\Http\Request $request, Activity $activity)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
 
        if (!$user->isAdmin() && $activity->user_id !== $user->id) {
            abort(403, 'You are not authorized to update this activity.');
        }
 
        $validated = $request->validate([
            'customer_id'   => ['nullable', 'exists:customers,id'],
            'lead_id'       => ['nullable', 'exists:leads,id'],
            'activity_type' => ['required', 'in:' . implode(',', array_keys(Activity::TYPES))],
            'description'   => ['required', 'string'],
            'activity_date' => ['required', 'date'],
        ]);
 
        if (empty($validated['customer_id']) && empty($validated['lead_id'])) {
            return back()
                ->withInput()
                ->withErrors(['customer_id' => 'Activity must be linked to a customer or a lead.']);
        }
 
        $activity->update($validated);
 
        return redirect()
            ->route('activities.index')
            ->with('success', 'Activity updated successfully.');
    }

    public function destroy(Activity $activity)
    {
        if (!auth()->user()->isAdmin() && $activity->user_id !== auth()->id()) {
            abort(403, 'You are not authorized to delete this activity.');
        }

        $activity->delete();

        return back()->with('success', 'Activity deleted.');
    }
}