<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentApiController extends Controller
{
    protected function guard()
    {
        if (! session('admin_logged_in')) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return null;
    }

    public function index()
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        return response()->json(Appointment::with('clinic')->latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'clinic_id' => ['required', 'exists:clinics,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required'],
            'reason' => ['required', 'string'],
        ]);

        $validated['status'] = 'pending';

        $appointment = Appointment::create($validated);
        Patient::syncFromAppointment($appointment);

        return response()->json($appointment->fresh()->load('clinic', 'patient'), 201);
    }

    public function show(Appointment $appointment)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        return response()->json($appointment->load('clinic', 'prescriptions'));
    }

    protected function syncAppointmentToPatient(Appointment $appointment)
    {
        Patient::syncFromAppointment($appointment);
    }

    public function update(Request $request, Appointment $appointment)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,confirmed,completed,cancelled'],
            'notes' => ['nullable', 'string'],
        ]);

        $appointment->update($validated);
        Patient::syncFromAppointment($appointment);

        return response()->json($appointment->fresh());
    }

    public function destroy(Appointment $appointment)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully.']);
    }
}
