<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Motorcycle;
use App\Models\MotorcycleSale;
use Illuminate\Support\Facades\DB;

class MotorcycleSaleController extends Controller
{
    public function index()
    {
        $sales = MotorcycleSale::with(['customer', 'motorcycle.brand', 'motorcycle.motorcycleModel'])->latest()->paginate(15);
        return view('admin.motorcycle-sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name_surname')->get();
        // Only motorcycles that are IN STOCK.
        $motorcycles = Motorcycle::with(['brand', 'motorcycleModel', 'color'])
            ->where('status', 'stokta')
            ->get();
            
        return view('admin.motorcycle-sales.create', compact('customers', 'motorcycles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'motorcycle_id' => 'required|exists:motorcycles,id',
            'sale_price' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        $motorcycle = Motorcycle::findOrFail($validated['motorcycle_id']);
        $customer = Customer::findOrFail($validated['customer_id']);

        // Check if customer has TC and Address
        if (empty($customer->tc_no) || empty($customer->address)) {
            return back()->with('error', 'Satış yapılamaz: Müşterinin TC No ve Adres bilgileri sistemde kayıtlı olmalıdır.');
        }
        
        if ($motorcycle->status !== 'stokta') {
            return back()->with('error', 'Bu motosiklet zaten satılmış veya stokta değil.');
        }

        DB::transaction(function () use ($validated, $motorcycle) {
            // 1. Create Sale Record
            $sale = MotorcycleSale::create($validated);

            // 2. Update Motorcycle Status
            $motorcycle->update(['status' => 'satildi']);

            // 3. Create Customer Transaction (Debt)
            $customer = Customer::findOrFail($validated['customer_id']);
            $customer->transactions()->create([
                'type' => 'debt',
                'amount' => $validated['sale_price'],
                'payment_method' => 'borc',
                'description' => "{$motorcycle->brand->name} {$motorcycle->motorcycleModel->name} Satışı (Şase: {$motorcycle->chassis_number})",
                'date' => $validated['sale_date'],
            ]);

            // 4. Recalculate Balance
            $customer->recalculateBalance();
        });

        return redirect()->route('admin.motorcycle-sales.index')->with('success', 'Motosiklet satışı başarıyla kaydedildi.');
    }
}
