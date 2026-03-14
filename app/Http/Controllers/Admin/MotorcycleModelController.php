<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\MotorcycleModel;
use Illuminate\Http\Request;

class MotorcycleModelController extends Controller
{
    public function index()
    {
        $models = MotorcycleModel::with('brand')->latest()->get();
        return view('admin.motorcycle-models.index', compact('models'));
    }

    public function create()
    {
        $brands = Brand::orderBy('name')->get();
        return view('admin.motorcycle-models.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
        ]);

        MotorcycleModel::create($validated);

        return redirect()->route('admin.motorcycle-models.index')->with('success', 'Model başarıyla eklendi.');
    }

    public function edit(MotorcycleModel $motorcycleModel)
    {
        $brands = Brand::orderBy('name')->get();
        return view('admin.motorcycle-models.edit', compact('motorcycleModel', 'brands'));
    }

    public function update(Request $request, MotorcycleModel $motorcycleModel)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
        ]);

        $motorcycleModel->update($validated);

        return redirect()->route('admin.motorcycle-models.index')->with('success', 'Model başarıyla güncellendi.');
    }

    public function destroy(MotorcycleModel $motorcycleModel)
    {
        $motorcycleModel->delete();

        return redirect()->route('admin.motorcycle-models.index')->with('success', 'Model başarıyla silindi.');
    }
}
