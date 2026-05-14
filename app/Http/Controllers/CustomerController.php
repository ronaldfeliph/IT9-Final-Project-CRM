<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

class CustomerController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $user  = auth()->user();
        $query = Customer::with('assignedUser');
 
        if ($user->isSalesStaff()) {
            $query->assignedTo($user->id);
        }
 
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }
 
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
 
        $customers = $query->latest()->paginate(15)->withQueryString();
 
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        $salesStaff = User::where('role', 'sales_staff')->get();
 
        return view('customers.create', compact('salesStaff'));
    }

    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->validated());
 
        return redirect()
            ->route('customers.show', $customer)
            ->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        $this->authorizeAccess($customer);
 
        $customer->load([
            'assignedUser',
            'activities' => fn ($q) => $q->latest('activity_date')->take(10),
            'followUps'  => fn ($q) => $q->orderBy('due_date'),
            'leads',
        ]);
 
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $this->authorizeAccess($customer);
 
        $salesStaff = User::where('role', 'sales_staff')->get();
 
        return view('customers.edit', compact('customer', 'salesStaff'));
    }
    
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
 
        return redirect()->route('customers.show', $customer)->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $this->authorizeAccess($customer);
 
        $customer->delete();
 
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    private function authorizeAccess(Customer $customer): void
    {
        $user = auth()->user();
 
        if ($user->isSalesStaff() && $customer->assigned_user_id !== $user->id) {
            abort(403, 'You are not authorized to access this customer.');
        }
    }
}