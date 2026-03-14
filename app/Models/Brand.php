<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function models()
    {
        return $this->hasMany(MotorcycleModel::class);
    }

    public function motorcycles()
    {
        return $this->hasMany(Motorcycle::class);
    }

    /**
     * Auto-generate slug from name before saving.
     */
    protected static function booted(): void
    {
        static::creating(function (Brand $brand) {
            if (empty($brand->slug)) {
                $brand->slug = Str::slug($brand->name);
            }
        });

        static::updating(function (Brand $brand) {
            if ($brand->isDirty('name') && !$brand->isDirty('slug')) {
                $brand->slug = Str::slug($brand->name);
            }
        });
    }
}
