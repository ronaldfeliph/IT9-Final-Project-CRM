<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFollowUpRequest;
use App\Http\Requests\UpdateFollowUpRequest;
use App\Models\Customer;
use App\Models\FollowUp;
use App\Models\Lead;
use App\Models\User;

class FollowUpController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $user  = auth()->user();
        $query = FollowUp::with(['user', 'customer', 'lead']);

        if ($user->isSalesStaff()) {
            $query->forUser($user->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->boolean('overdue')) {
            $query->overdue();
        }

        if ($request->boolean('upcoming')) {
            $query->upcoming(7);
        }

        $followUps = $query->orderBy('due_date')->paginate(15)->withQueryString();

        return view('follow-ups.index', compact('followUps'));
    }

    public function create(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();

        $customers = $user->isSalesStaff() ? Customer::assignedTo($user->id)->get() : Customer::all();

        $leads = $user->isSalesStaff() ? Lead::assignedTo($user->id)->active()->get() : Lead::active()->get();

        $salesStaff = User::where('role', 'sales_staff')->get();
        $selectedCustomerId = $request->query('customer_id');
        $selectedLeadId = $request->query('lead_id');

        return view('follow-ups.create', compact('customers','leads','salesStaff','selectedCustomerId','selectedLeadId'
        ));
    }

    public function store(StoreFollowUpRequest $request)
    {
        $validated = $request->validated();

        FollowUp::create($validated);

        if (!empty($validated['customer_id'])) {
            return redirect()->route('customers.show', $validated['customer_id'])->with('success', 'Follow-up scheduled successfully.');
        }

        return redirect()->route('leads.show', $validated['lead_id'])->with('success', 'Follow-up scheduled successfully.');
    }

    public function edit(FollowUp $followUp)
    {
        $this->authorizeAccess($followUp);

        if ($followUp->isCompleted()) {
            return back()->with('error', 'Completed follow-ups cannot be edited.');
        }

        $user = auth()->user();

        $customers = $user->isSalesStaff() ? Customer::assignedTo($user->id)->get() : Customer::all();

        $leads = $user->isSalesStaff() ? Lead::assignedTo($user->id)->active()->get() : Lead::active()->get();

        $salesStaff = User::where('role', 'sales_staff')->get();

        return view('follow-ups.edit', compact('followUp', 'customers', 'leads', 'salesStaff'));
    }

    public function update(UpdateFollowUpRequest $request, FollowUp $followUp)
    {
        $followUp->update($request->validated());

        return redirect()->route('follow-ups.index')->with('success', 'Follow-up updated successfully.');
    }

    public function markComplete(FollowUp $followUp)
    {
        $this->authorizeAccess($followUp);

        $followUp->update(['status' => 'completed']);

        return back()->with('success', 'Follow-up marked as completed.');
    }

    public function reopen(FollowUp $followUp)
    {
        $this->authorizeAccess($followUp);

        $followUp->update(['status' => 'pending']);

        return back()->with('success', 'Follow-up reopened.');
    }

    public function destroy(FollowUp $followUp)
    {
        $this->authorizeAccess($followUp);

        $followUp->delete();

        return redirect()->route('follow-ups.index')->with('success', 'Follow-up deleted.');
    }

    private function authorizeAccess(FollowUp $followUp): void
    {
        $user = auth()->user();

        if ($user->isSalesStaff() && $followUp->user_id !== $user->id) {
            abort(403, 'You are not authorized to access this follow-up.');
        }
    }
}