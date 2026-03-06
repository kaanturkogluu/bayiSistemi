<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_surname',
        'phone'
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }
}
