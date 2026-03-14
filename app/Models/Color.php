<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Color extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'hex',
    ];

    protected static function booted(): void
    {
        static::creating(function (Color $color) {
            if (empty($color->slug)) {
                $color->slug = Str::slug($color->name);
            }
        });

        static::updating(function (Color $color) {
            if ($color->isDirty('name') && !$color->isDirty('slug')) {
                $color->slug = Str::slug($color->name);
            }
        });
    }
}
