<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Schedule;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $search = $request->string('search');
        $clinicId = $request->input('clinic_id');
        $scheduleId = $request->input('schedule_id');
        $appointmentId = $request->input('appointment_id');
        $prescriptionId = $request->input('prescription_id');
        $status = $request->input('status');

        $patients = Patient::with(['clinic', 'schedule', 'appointment', 'prescription'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%')
                    ->orWhere('sex', 'like', '%'.$search.'%')
                    ->orWhere('address', 'like', '%'.$search.'%');
            })
            ->when($clinicId, fn ($query) => $query->where('clinic_id', $clinicId))
            ->when($scheduleId, fn ($query) => $query->where('schedule_id', $scheduleId))
            ->when($appointmentId, fn ($query) => $query->where('appointment_id', $appointmentId))
            ->when($prescriptionId, fn ($query) => $query->where('prescription_id', $prescriptionId))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $clinics = Clinic::orderBy('name')->get();
        $schedules = Schedule::orderBy('day_order')->get();
        $appointments = Appointment::orderBy('appointment_date', 'desc')->get();
        $prescriptions = Prescription::orderBy('id', 'desc')->get();

        return view('admin.patients.index', compact(
            'patients',
            'search',
            'clinicId',
            'scheduleId',
            'appointmentId',
            'prescriptionId',
            'status',
            'clinics',
            'schedules',
            'appointments',
            'prescriptions'
        ));
    }

    public function create()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $clinics = Clinic::orderBy('name')->get();
        $schedules = Schedule::orderBy('day_order')->get();
        $appointments = Appointment::orderBy('appointment_date', 'desc')->get();
        $prescriptions = Prescription::orderBy('id', 'desc')->get();

        return view('admin.patients.create', compact('clinics', 'schedules', 'appointments', 'prescriptions'));
    }

    public function store(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'sex' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'clinic_id' => ['nullable', 'exists:clinics,id'],
            'schedule_id' => ['nullable', 'exists:schedules,id'],
            'appointment_id' => ['nullable', 'exists:appointments,id'],
            'prescription_id' => ['nullable', 'exists:prescriptions,id'],
            'status' => ['nullable', 'in:pending,active'],
            'notes' => ['nullable', 'string'],
        ]);

        Patient::create($validated);

        return redirect()->route('admin.patients.index')->with('success', 'Patient created successfully.');
    }

    public function edit(Patient $patient)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $clinics = Clinic::orderBy('name')->get();
        $schedules = Schedule::orderBy('day_order')->get();
        $appointments = Appointment::orderBy('appointment_date', 'desc')->get();
        $prescriptions = Prescription::orderBy('id', 'desc')->get();

        return view('admin.patients.edit', compact('patient', 'clinics', 'schedules', 'appointments', 'prescriptions'));
    }

    public function update(Request $request, Patient $patient)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'sex' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'clinic_id' => ['nullable', 'exists:clinics,id'],
            'schedule_id' => ['nullable', 'exists:schedules,id'],
            'appointment_id' => ['nullable', 'exists:appointments,id'],
            'prescription_id' => ['nullable', 'exists:prescriptions,id'],
            'status' => ['nullable', 'in:pending,active'],
            'notes' => ['nullable', 'string'],
        ]);

        $patient->update($validated);

        return redirect()->route('admin.patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $patient->delete();

        return redirect()->route('admin.patients.index')->with('success', 'Patient deleted successfully.');
    }
}
