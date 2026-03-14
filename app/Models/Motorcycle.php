<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorcycle extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'motorcycle_model_id',
        'color_id',
        'year',
        'chassis_number',
        'engine_number',
        'arrival_date',
        'status',
        'purchase_price',
        'sale_price',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function motorcycleModel()
    {
        return $this->belongsTo(MotorcycleModel::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function sales()
    {
        return $this->hasMany(MotorcycleSale::class);
    }
}
