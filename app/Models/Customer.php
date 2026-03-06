<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Customer extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $fillable = [
        'name_surname',
        'phone',
        'balance'
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function transactions()
    {
        return $this->hasMany(CustomerTransaction::class);
    }

    public function recalculateBalance()
    {
        $debt = $this->transactions()->where('type', 'debt')->sum('amount');
        $payment = $this->transactions()->where('type', 'payment')->sum('amount');
        $this->balance = $debt - $payment;
        $this->save();
    }
}
