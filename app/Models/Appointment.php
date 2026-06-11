<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'patient_name',
        'phone',
        'email',
        'patient_age',
        'sex',
        'clinic_id',
        'appointment_date',
        'appointment_time',
        'reason',
        'status',
        'notes',
        'report_path',
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
