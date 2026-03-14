<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Maintenance;
use App\Models\CustomerTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Maintenance::with(['customer', 'vehicle'])->latest();

        $statusFilter = $request->query('status');
        if ($statusFilter && in_array($statusFilter, ['bekliyor', 'tamamlandi'])) {
            $query->where('status', $statusFilter);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', function ($cq) use ($search) {
                    $cq->withTrashed()->where('name_surname', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                })->orWhereHas('vehicle', function ($vq) use ($search) {
                    $vq->withTrashed()->where('plate', 'like', "%{$search}%");
                });
            });
        }

        $maintenances = $query->paginate(10)->withQueryString();
        $searchQuery = $request->search;

        return view('admin.maintenances.index', compact('maintenances', 'searchQuery', 'statusFilter'));
    }

    public function create(Request $request)
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

        $selectedCustomerId = $request->query('customer_id');

        return view('admin.maintenances.create', compact('customers', 'customerVehicles', 'selectedCustomerId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'km' => ['nullable', 'numeric', 'min:0'],
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
                'km' => $request->km,
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

            // Create debt transaction
            $maintenance->transactions()->create([
                'customer_id' => $maintenance->customer_id,
                'type' => 'debt',
                'amount' => $maintenance->total_cost,
                'description' => 'Bakım Hizmet Bedeli (#' . str_pad($maintenance->id, 5, '0', STR_PAD_LEFT) . ')',
                'date' => now(),
            ]);

            // Recalculate balance
            $maintenance->customer->recalculateBalance();

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
        $maintenance->load('parts');

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

        return view('admin.maintenances.edit', compact('maintenance', 'customers', 'customerVehicles'));
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'km' => ['nullable', 'numeric', 'min:0'],
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
            $maintenance->update([
                'customer_id' => $request->customer_id,
                'vehicle_id' => $request->vehicle_id,
                'km' => $request->km,
                'labor_cost' => $request->labor_cost,
                'total_cost' => $request->total_cost,
            ]);

            // Clear old parts
            $maintenance->parts()->delete();

            // Insert new parts
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

            // Update debt transaction
            $debtTransaction = $maintenance->transactions()->where('type', 'debt')->first();
            if ($debtTransaction) {
                $debtTransaction->update([
                    'customer_id' => $maintenance->customer_id,
                    'amount' => $maintenance->total_cost,
                ]);
            } else {
                $maintenance->transactions()->create([
                    'customer_id' => $maintenance->customer_id,
                    'type' => 'debt',
                    'amount' => $maintenance->total_cost,
                    'description' => 'Bakım Hizmet Bedeli (#' . str_pad($maintenance->id, 5, '0', STR_PAD_LEFT) . ')',
                    'date' => now(),
                ]);
            }

            // Recalculate balances (just in case customer changed)
            $maintenance->customer->recalculateBalance();

            DB::commit();

            return redirect()->route('admin.maintenances.index')
                ->with('success', 'Bakım kaydı başarıyla güncellendi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Bakım güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function complete(Request $request, Maintenance $maintenance)
    {
        // Auto-complete any uncompleted parts
        foreach ($maintenance->parts as $part) {
            if (!$part->is_completed) {
                $part->is_completed = true;
                $part->completed_by = \Illuminate\Support\Facades\Auth::id();
                $part->save();
            }
        }

        $maintenance->status = 'tamamlandi';
        $maintenance->completed_by = \Illuminate\Support\Facades\Auth::id();
        $maintenance->save();

        return redirect()->route('admin.maintenances.show', $maintenance)
            ->with('success', 'Bakım admin tarafından başarıyla tamamlandı.');
    }

    public function destroy(Maintenance $maintenance)
    {
        $customer = $maintenance->customer;

        // Delete associated transactions
        $maintenance->transactions()->delete();

        $maintenance->delete();

        // Recalculate balance
        if ($customer) {
            $customer->recalculateBalance();
        }

        return redirect()->route('admin.maintenances.index')
            ->with('success', 'Bakım kaydı başarıyla silindi.');
    }
}
