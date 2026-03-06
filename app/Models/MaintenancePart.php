<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintenancePart extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenance_id',
        'name',
        'quantity',
        'unit_price',
        'note',
        'is_completed',
        'completed_by',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
    ];

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class);
    }

    public function completedBy()
    {
        return $this->belongsTo(Account::class, 'completed_by');
    }
}
