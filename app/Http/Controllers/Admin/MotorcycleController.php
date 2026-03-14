<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Motorcycle;
use App\Models\MotorcycleModel;
use Illuminate\Http\Request;

class MotorcycleController extends Controller
{
    public function index()
    {
        $motorcycles = Motorcycle::with(['brand', 'motorcycleModel', 'color'])->latest()->get();
        return view('admin.motorcycles.index', compact('motorcycles'));
    }

    public function create()
    {
        $brands = Brand::orderBy('name')->get();
        $colors = Color::orderBy('name')->get();
        return view('admin.motorcycles.create', compact('brands', 'colors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'motorcycle_model_id' => 'required|exists:motorcycle_models,id',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'arrival_date' => 'required|date',
            'status' => 'required|in:stokta,satildi,revize_edildi',
            'purchase_price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.color_id' => 'required|exists:colors,id',
            'items.*.chassis_number' => 'required|string|unique:motorcycles,chassis_number',
            'items.*.engine_number' => 'required|string|unique:motorcycles,engine_number',
        ]);

        foreach ($validated['items'] as $item) {
            Motorcycle::create([
                'brand_id' => $validated['brand_id'],
                'motorcycle_model_id' => $validated['motorcycle_model_id'],
                'year' => $validated['year'],
                'arrival_date' => $validated['arrival_date'],
                'status' => $validated['status'],
                'purchase_price' => $validated['purchase_price'],
                'sale_price' => $validated['sale_price'],
                'color_id' => $item['color_id'],
                'chassis_number' => $item['chassis_number'],
                'engine_number' => $item['engine_number'],
            ]);
        }

        return redirect()->route('admin.motorcycles.index')->with('success', count($validated['items']) . ' adet motor başarıyla stoğa eklendi.');
    }

    public function edit(Motorcycle $motorcycle)
    {
        $brands = Brand::orderBy('name')->get();
        $colors = Color::orderBy('name')->get();
        $models = MotorcycleModel::where('brand_id', $motorcycle->brand_id)->orderBy('name')->get();
        return view('admin.motorcycles.edit', compact('motorcycle', 'brands', 'colors', 'models'));
    }

    public function update(Request $request, Motorcycle $motorcycle)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'motorcycle_model_id' => 'required|exists:motorcycle_models,id',
            'color_id' => 'required|exists:colors,id',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'chassis_number' => 'required|string|unique:motorcycles,chassis_number,' . $motorcycle->id,
            'engine_number' => 'required|string|unique:motorcycles,engine_number,' . $motorcycle->id,
            'arrival_date' => 'required|date',
            'status' => 'required|in:stokta,satildi,revize_edildi',
            'purchase_price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
        ]);

        $motorcycle->update($validated);

        return redirect()->route('admin.motorcycles.index')->with('success', 'Motor bilgileri güncellendi.');
    }

    public function destroy(Motorcycle $motorcycle)
    {
        $motorcycle->delete();
        return redirect()->route('admin.motorcycles.index')->with('success', 'Motor kaydı silindi.');
    }

    public function getModelsByBrand($brandId)
    {
        $models = MotorcycleModel::where('brand_id', $brandId)->orderBy('name')->get();
        return response()->json($models);
    }
}
