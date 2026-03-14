<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MotorcycleModel extends Model
{
    protected $fillable = [
        'brand_id',
        'name',
        'slug',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function motorcycles()
    {
        return $this->hasMany(Motorcycle::class);
    }

    protected static function booted(): void
    {
        static::creating(function (MotorcycleModel $model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });

        static::updating(function (MotorcycleModel $model) {
            if ($model->isDirty('name') && !$model->isDirty('slug')) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
}
