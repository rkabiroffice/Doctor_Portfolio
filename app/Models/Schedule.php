<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'day_name',
        'day_order',
        'start_time',
        'end_time',
        'appointment_limit',
        'is_closed',
    ];

    protected $casts = [
        'day_order' => 'integer',
        'appointment_limit' => 'integer',
        'is_closed' => 'boolean',
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
