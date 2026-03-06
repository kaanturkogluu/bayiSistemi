<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Maintenance::with(['customer', 'vehicle'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('name_surname', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            })->orWhereHas('vehicle', function ($q) use ($search) {
                $q->where('plate', 'like', "%{$search}%");
            });
        }

        $maintenances = $query->paginate(10)->withQueryString();
        $searchQuery = $request->search;

        return view('admin.maintenances.index', compact('maintenances', 'searchQuery'));
    }

    public function create()
    {
        // Load customers with their vehicles
        $customers = Customer::with('vehicles')->orderBy('name_surname')->get();
        // Create a map to pass cleanly to Javascript via Alpine
        $customerVehicles = $customers->mapWithKeys(function ($c) {
            return [
                $c->id => $c->vehicles->map(function ($v) {
                    return ['id' => $v->id, 'plate' => $v->plate];
                })->values()->toArray()
            ];
        });
        return view('admin.maintenances.create', compact('customers', 'customerVehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'labor_cost' => ['required', 'numeric', 'min:0'],
            'total_cost' => ['required', 'numeric', 'min:0'],
            'parts' => ['nullable', 'array'],
            'parts.*.name' => ['required_with:parts', 'string', 'max:255'],
            'parts.*.quantity' => ['required_with:parts', 'integer', 'min:1'],
            'parts.*.unit_price' => ['required_with:parts', 'numeric', 'min:0'],
            'parts.*.note' => ['nullable', 'string', 'max:500'],
        ]);

        DB::beginTransaction();

        try {
            $maintenance = Maintenance::create([
                'customer_id' => $request->customer_id,
                'vehicle_id' => $request->vehicle_id,
                'labor_cost' => $request->labor_cost,
                'total_cost' => $request->total_cost,
            ]);

            if ($request->has('parts') && is_array($request->parts)) {
                foreach ($request->parts as $partData) {
                    $maintenance->parts()->create([
                        'name' => $partData['name'],
                        'quantity' => $partData['quantity'],
                        'unit_price' => $partData['unit_price'],
                        'note' => $partData['note'] ?? null,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.maintenances.index')
                ->with('success', 'Bakım kaydı başarıyla oluşturuldu.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Bakım kaydedilirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function show(Maintenance $maintenance)
    {
        $maintenance->load(['customer', 'parts']);
        return view('admin.maintenances.show', compact('maintenance'));
    }

    public function edit(Maintenance $maintenance)
    {
        // To be implemented in next step if user requests editing
        abort(404, 'Düzenleme modülü daha sonra eklenecektir.');
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        // To be implemented
        abort(404);
    }

    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();
        return redirect()->route('admin.maintenances.index')
            ->with('success', 'Bakım kaydı başarıyla silindi.');
    }
}
