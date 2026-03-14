<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('models')->latest()->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
        ]);

        Brand::create($validated);

        return redirect()->route('admin.brands.index')->with('success', 'Marka başarıyla eklendi.');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
        ]);

        $brand->update($validated);

        return redirect()->route('admin.brands.index')->with('success', 'Marka başarıyla güncellendi.');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->models()->count() > 0) {
            return back()->with('error', 'Bu markaya ait modeller olduğu için silinemez.');
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Marka başarıyla silindi.');
    }
}
