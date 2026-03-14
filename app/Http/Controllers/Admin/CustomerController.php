<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount('vehicles')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name_surname', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        }

        $customers = $query->paginate(10)->withQueryString();
        $searchQuery = $request->search;
        return view('admin.customers.index', compact('customers', 'searchQuery'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_surname' => ['required', 'string', 'max:255'],
            'tc_no' => ['nullable', 'string', 'digits:11'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'plates' => ['nullable', 'array'],
            'plates.*' => ['nullable', 'string', 'max:50']
        ]);

        // Spam / Duplicate check: If a customer with the exact same name and phone already exists, don't create a new one.
        $existingCustomer = Customer::where('name_surname', $validated['name_surname'])
            ->where('phone', $validated['phone'] ?? null)
            ->first();

        if ($existingCustomer) {
            return redirect()->route('admin.customers.index')
                ->with('success', 'Müşteri başarıyla kayıt edildi.'); // Show success to not confuse the user, but prevent duplicate.
        }

        $customer = Customer::create([
            'name_surname' => $validated['name_surname'],
            'tc_no' => $validated['tc_no'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        if (!empty($validated['plates'])) {
            foreach ($validated['plates'] as $plate) {
                if (!empty(trim($plate))) {
                    $customer->vehicles()->create(['plate' => strtoupper(trim($plate))]);
                }
            }
        }

        return redirect()->route('admin.customers.index')
            ->with('success', 'Müşteri başarıyla kayıt edildi.');
    }

    public function quickStore(Request $request)
    {
        $validated = $request->validate([
            'name_surname' => ['required', 'string', 'max:255'],
            'tc_no' => ['nullable', 'string', 'digits:11'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
        ]);

        $customer = Customer::create($validated);

        return response()->json([
            'success' => true,
            'customer' => $customer
        ]);
    }

    public function show(Customer $customer)
    {
        $customer->load([
            'transactions' => function ($query) {
                $query->latest('date')->latest('id');
            },
            'vehicles',
            'maintenances'
        ]);

        return view('admin.customers.show', compact('customer'));
    }

    public function maintenances(Customer $customer)
    {
        $maintenances = $customer->maintenances()
            ->with(['vehicle', 'parts', 'completedBy'])
            ->latest()
            ->paginate(10);

        return view('admin.customers.maintenances', compact('customer', 'maintenances'));
    }

    public function edit(Customer $customer)
    {
        $customer->load('vehicles');
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name_surname' => ['required', 'string', 'max:255'],
            'tc_no' => ['nullable', 'string', 'digits:11'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'plates' => ['nullable', 'array'],
            'plates.*' => ['nullable', 'string', 'max:50']
        ]);

        $customer->update([
            'name_surname' => $validated['name_surname'],
            'tc_no' => $validated['tc_no'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        // Re-sync plates: delete existing, and recreate
        $customer->vehicles()->delete();
        if (!empty($validated['plates'])) {
            foreach ($validated['plates'] as $plate) {
                if (!empty(trim($plate))) {
                    $customer->vehicles()->create(['plate' => strtoupper(trim($plate))]);
                }
            }
        }

        return redirect()->route('admin.customers.index')
            ->with('success', 'Müşteri bilgileri başarıyla güncellendi.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Müşteri başarıyla silindi.');
    }
}
