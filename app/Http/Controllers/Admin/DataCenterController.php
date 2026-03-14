<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Color;
use App\Models\MotorcycleModel;
use Illuminate\Http\Request;

class DataCenterController extends Controller
{
    public function index()
    {
        $brandsCount = Brand::count();
        $colorsCount = Color::count();
        $modelsCount = MotorcycleModel::count();

        return view('admin.data-center.index', compact('brandsCount', 'colorsCount', 'modelsCount'));
    }
}
