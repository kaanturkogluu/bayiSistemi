<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotorcycleSale extends Model
{
    protected $fillable = [
        'customer_id',
        'motorcycle_id',
        'sale_price',
        'sale_date',
        'notes',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function motorcycle()
    {
        return $this->belongsTo(Motorcycle::class);
    }
}
