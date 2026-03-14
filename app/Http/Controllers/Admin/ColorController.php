<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::latest()->get();
        return view('admin.colors.index', compact('colors'));
    }

    public function create()
    {
        return view('admin.colors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:colors,name',
            'hex' => 'nullable|string|max:7',
        ]);

        Color::create($validated);

        return redirect()->route('admin.colors.index')->with('success', 'Renk başarıyla eklendi.');
    }

    public function edit(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:colors,name,' . $color->id,
            'hex' => 'nullable|string|max:7',
        ]);

        $color->update($validated);

        return redirect()->route('admin.colors.index')->with('success', 'Renk başarıyla güncellendi.');
    }

    public function destroy(Color $color)
    {
        $color->delete();

        return redirect()->route('admin.colors.index')->with('success', 'Renk başarıyla silindi.');
    }
}
