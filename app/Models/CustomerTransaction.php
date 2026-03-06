<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Maintenance;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class CustomerTransaction extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'customer_id',
        'maintenance_id',
        'type', // 'debt', 'payment'
        'amount',
        'payment_method', // 'nakit', 'kart', 'borc'
        'description',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class);
    }
}
