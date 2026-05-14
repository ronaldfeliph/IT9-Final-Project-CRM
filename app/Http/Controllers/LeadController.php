<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $user  = auth()->user();
        $query = Lead::with(['assignedUser', 'customer']);

        if ($user->isSalesStaff()) {
            $query->assignedTo($user->id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('source', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('priority')) {
            $query->byPriority($request->priority);
        }

        $leads      = $query->latest()->paginate(15)->withQueryString();
        $statuses   = Lead::STATUSES;
        $priorities = Lead::PRIORITIES;

        return view('leads.index', compact('leads', 'statuses', 'priorities'));
    }

    public function create()
    {
        $salesStaff = User::where('role', 'sales_staff')->get();
        $customers  = Customer::active()->get();
        $statuses   = Lead::STATUSES;
        $priorities = Lead::PRIORITIES;

        return view('leads.create', compact('salesStaff', 'customers', 'statuses', 'priorities'));
    }

    public function store(StoreLeadRequest $request)
    {
        $lead = Lead::create($request->validated());

        return redirect()
            ->route('leads.show', $lead)
            ->with('success', 'Lead created successfully.');
    }

    public function show(Lead $lead)
    {
        $this->authorizeAccess($lead);

        $lead->load([
            'assignedUser',
            'customer',
            'activities' => fn ($q) => $q->latest('activity_date')->take(10),
            'followUps'  => fn ($q) => $q->orderBy('due_date'),
        ]);

        $statuses = Lead::STATUSES;

        return view('leads.show', compact('lead', 'statuses'));
    }

    public function edit(Lead $lead)
    {
        $this->authorizeAccess($lead);

        $salesStaff = User::where('role', 'sales_staff')->get();
        $customers  = Customer::active()->get();
        $statuses   = Lead::STATUSES;
        $priorities = Lead::PRIORITIES;

        return view('leads.edit', compact('lead', 'salesStaff', 'customers', 'statuses', 'priorities'));
    }

    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        $lead->update($request->validated());

        return redirect()
            ->route('leads.show', $lead)
            ->with('success', 'Lead updated successfully.');
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $this->authorizeAccess($lead);

        $validated = $request->validate([
            'status' => ['required', 'in:' . implode(',', array_keys(Lead::STATUSES))],
        ]);

        $lead->update($validated);

        return back()->with('success', 'Lead status updated.');
    }

    public function convertToCustomer(Lead $lead)
    {
        $this->authorizeAccess($lead);

        if ($lead->customer_id) {
            return back()->with('error', 'This lead is already linked to a customer.');
        }

        $customer = Customer::create([
            'first_name' => $lead->name,
            'last_name' => '',
            'email' => $lead->email ?? '',
            'phone' => $lead->phone ?? '',
            'status' => 'active',
            'assigned_user_id' => $lead->assigned_user_id,
        ]);

        $lead->update([
            'customer_id' => $customer->id,
            'status' => 'won',
        ]);

        return redirect()
            ->route('customers.show', $customer)
            ->with('success', 'Lead successfully converted to customer.');
    }

    public function destroy(Lead $lead)
    {
        $this->authorizeAccess($lead);

        $lead->delete();

        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }

    private function authorizeAccess(Lead $lead): void
    {
        $user = auth()->user();

        if ($user->isSalesStaff() && $lead->assigned_user_id !== $user->id) {
            abort(403, 'You are not authorized to access this lead.');
        }
    }
}