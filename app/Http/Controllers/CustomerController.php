<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($search = $request->get('search')) {
            $query->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%")
                ->orWhere('company', 'like', "%{$search}%");
        }

        $customers = $query->paginate(10);

        return view('customers.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z-]+$/',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z-]+$/',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|max:255|regex:/^\+?[0-9 ]+$/',
            'address' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'cui_firma' => 'nullable|string|regex:/^\d+$/',
            'numar_registru_comert' => 'nullable|string|regex:/^\d+$/',
            'notes' => 'nullable|string',
            'email_opt_in' => 'boolean',
        ], [
            'first_name.required' => 'First name is required.',
            'first_name.regex' => 'First name should contain only letters and hyphens.',
            'last_name.required' => 'Last name is required.',
            'last_name.regex' => 'Last name should contain only letters and hyphens.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email is already taken.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number should contain only numbers, spaces, and an optional leading +.',
            'cui_firma.regex' => 'CUI Firma should contain only numbers.',
            'numar_registru_comert.regex' => 'Numar Registru Comert should contain only numbers.',
            'email_opt_in' => 'boolean',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function updateNotes(Request $request, Customer $customer)
    {
        $request->validate([
            'notes' => 'nullable|string',
        ], [
            'notes.string' => 'Notes must be a string.',
        ]);

        $customer->update($request->only('notes'));

        return redirect()->route('customers.show', $customer)->with('status', 'Notes updated successfully!');
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z-]+$/',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z-]+$/',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'required|string|max:255|regex:/^\+?[0-9 ]+$/',
            'address' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'cui_firma' => 'nullable|string|regex:/^\d+$/',
            'numar_registru_comert' => 'nullable|string|regex:/^\d+$/',
            'notes' => 'nullable|string',
            'email_opt_in' => 'boolean',
        ], [
            'first_name.required' => 'First name is required.',
            'first_name.regex' => 'First name should contain only letters and hyphens.',
            'last_name.required' => 'Last name is required.',
            'last_name.regex' => 'Last name should contain only letters and hyphens.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email is already taken.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number should contain only numbers, spaces, and an optional leading +.',
            'cui_firma.regex' => 'CUI Firma should contain only numbers.',
            'numar_registru_comert.regex' => 'Numar Registru Comert should contain only numbers.',
            'email_opt_in' => 'boolean',
        ]);

        $customer = Customer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
