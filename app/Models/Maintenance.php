<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Maintenance extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'customer_id',
        'vehicle_id',
        'km',
        'labor_cost',
        'total_cost',
        'status',
        'completed_by',
    ];

    public function completedBy()
    {
        return $this->belongsTo(Account::class, 'completed_by');
    }

    public function transactions()
    {
        return $this->hasMany(CustomerTransaction::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class)->withTrashed();
    }

    public function parts()
    {
        return $this->hasMany(MaintenancePart::class);
    }
}
