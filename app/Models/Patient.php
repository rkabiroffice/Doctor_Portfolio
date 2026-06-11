<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'name',
        'email',
        'phone',
        'sex',
        'patient_age',
        'address',
        'clinic_id',
        'schedule_id',
        'appointment_id',
        'prescription_id',
        'notes',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function (self $patient) {
            if (empty($patient->uid)) {
                $patient->uid = self::generateUniqueUid();
            }
        });
    }

    protected static function generateUniqueUid(): string
    {
        do {
            $uid = 'P-' . strtoupper(Str::random(8));
        } while (self::where('uid', $uid)->exists());

        return $uid;
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function prescriptions()
    {
        return $this->hasManyThrough(Prescription::class, Appointment::class, 'patient_id', 'appointment_id');
    }

    public function refreshStatus(): void
    {
        $hasCompletedAppointmentWithPrescription = $this->appointments()
            ->where('status', 'completed')
            ->whereHas('prescriptions')
            ->exists();

        $newStatus = $hasCompletedAppointmentWithPrescription ? 'active' : 'pending';

        if ($this->status !== $newStatus) {
            $this->update(['status' => $newStatus]);
        }
    }

    public static function syncFromAppointment(Appointment $appointment): self
    {
        $patient = null;

        if ($appointment->patient_id) {
            $patient = self::find($appointment->patient_id);
        }

        if (! $patient && $appointment->email) {
            $patient = self::where('email', $appointment->email)->first();
        }

        if (! $patient && $appointment->phone) {
            $patient = self::where('phone', $appointment->phone)->first();
        }

        if (! $patient) {
            $patient = new self();
        }

        $patient->fill([
            'name' => $appointment->patient_name,
            'email' => $appointment->email,
            'phone' => $appointment->phone,
            'sex' => $appointment->sex,
            'patient_age' => $appointment->patient_age,
            'clinic_id' => $appointment->clinic_id,
            'appointment_id' => $appointment->id,
            'prescription_id' => $appointment->prescription?->id,
            'notes' => $appointment->notes,
        ]);

        if (! $patient->exists) {
            $patient->status = 'pending';
        }

        $patient->save();

        if ($appointment->patient_id !== $patient->id) {
            $appointment->patient_id = $patient->id;
            $appointment->save();
        }

        $patient->refreshStatus();

        return $patient;
    }
}
