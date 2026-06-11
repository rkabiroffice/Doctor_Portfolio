<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        // Temporarily commented out for debugging
        // if (! session('admin_logged_in')) {
        //     return redirect()->route('admin.login');
        // }

        $search = $request->string('search');
        $status = $request->string('status');

        // Convert Stringable to string to avoid issues with when() condition
        $searchStr = (string) $search;
        $statusStr = (string) $status;

        $appointments = Appointment::with('clinic', 'patient')
            ->when($searchStr, fn ($query) => $query->where('patient_name', 'like', '%'.$searchStr.'%'))
            ->when($statusStr, fn ($query) => $query->where('status', $statusStr))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.appointments.index', compact('appointments', 'search', 'status'));
    }

    public function create(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $patient = null;
        $patientId = $request->query('patient_id');

        if ($patientId) {
            $patient = Patient::find($patientId);
        }

        $clinics = Clinic::orderBy('name')->get();

        return view('admin.appointments.create', compact('clinics', 'patient'));
    }

    public function store(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'patient_id' => ['nullable', 'exists:patients,id'],
            'patient_name' => ['required_without:patient_id', 'string', 'max:255'],
            'phone' => ['required_without:patient_id', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'patient_age' => ['required_without:patient_id', 'integer', 'min:0'],
            'sex' => ['required_without:patient_id', 'string', 'max:20'],
            'clinic_id' => ['required', 'exists:clinics,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'string', 'max:50'],
            'reason' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        if ($validated['patient_id'] ?? false) {
            $patient = Patient::find($validated['patient_id']);
            $validated['patient_name'] = $patient->name;
            $validated['phone'] = $patient->phone;
            $validated['email'] = $patient->email;
            $validated['patient_age'] = $patient->patient_age;
            $validated['sex'] = $patient->sex;
        }

        $validated['status'] = 'confirmed';

        $appointment = Appointment::create($validated);
        $this->syncAppointmentToPatient($appointment);

        return redirect()->route('admin.appointments.show', $appointment)->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $appointment->load('clinic', 'patient', 'reports', 'prescription.reports', 'prescription.prescriptionMedicines.medicine');

        return view('admin.appointments.show', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,confirmed,completed,cancelled'],
        ]);

        $appointment->update($validated);
        $this->syncAppointmentToPatient($appointment);

        return redirect()->back()->with('success', 'Appointment status updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $appointment->delete();

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment deleted successfully.');
    }

    public function export($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $appointments = Appointment::with('clinic')->latest()->get();

        if ($format === 'csv') {
            $filename = 'appointments_' . date('Y-m-d_His') . '.csv';
            $handle = fopen('php://output', 'w');
            
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            fputcsv($handle, ['ID', 'Patient Name', 'Phone', 'Email', 'Clinic', 'Date', 'Time', 'Status', 'Reason']);
            
            if ($appointments->isEmpty()) {
                fputcsv($handle, ['No data available', '', '', '', '', '', '', '', '']);
            } else {
                foreach ($appointments as $appointment) {
                    fputcsv($handle, [
                        $appointment->id,
                        $appointment->patient_name,
                        $appointment->phone,
                        $appointment->email ?? '',
                        $appointment->clinic->name ?? 'N/A',
                        $appointment->appointment_date->format('Y-m-d'),
                        $appointment->appointment_time,
                        $appointment->status,
                        $appointment->reason
                    ]);
                }
            }
            
            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'appointments_' . date('Y-m-d_His') . '.xls';
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            echo '<table border="1">';
            echo '<thead><tr><th>ID</th><th>Patient Name</th><th>Phone</th><th>Email</th><th>Clinic</th><th>Date</th><th>Time</th><th>Status</th><th>Reason</th></tr></thead>';
            echo '<tbody>';
            
            if ($appointments->isEmpty()) {
                echo '<tr><td colspan="9" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($appointments as $appointment) {
                    echo '<tr>';
                    echo '<td>' . $appointment->id . '</td>';
                    echo '<td>' . htmlspecialchars($appointment->patient_name) . '</td>';
                    echo '<td>' . htmlspecialchars($appointment->phone) . '</td>';
                    echo '<td>' . htmlspecialchars($appointment->email ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($appointment->clinic->name ?? 'N/A') . '</td>';
                    echo '<td>' . $appointment->appointment_date->format('Y-m-d') . '</td>';
                    echo '<td>' . $appointment->appointment_time . '</td>';
                    echo '<td>' . $appointment->status . '</td>';
                    echo '<td>' . htmlspecialchars($appointment->reason) . '</td>';
                    echo '</tr>';
                }
            }
            
            echo '</tbody></table>';
            exit;
        }

        if ($format === 'pdf') {
            $html = '<html><head><style>body{font-family:Arial,sans-serif;font-size:12px;}table{width:100%;border-collapse:collapse;margin-top:20px;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f4f4f4;font-weight:bold;}h1{text-align:center;color:#333;}</style></head><body>';
            $html .= '<h1>Appointments Report</h1>';
            $html .= '<p>Generated on: ' . date('d M Y H:i:s') . '</p>';
            $html .= '<table><thead><tr><th>ID</th><th>Patient</th><th>Phone</th><th>Clinic</th><th>Date</th><th>Status</th></tr></thead><tbody>';
            
            if ($appointments->isEmpty()) {
                $html .= '<tr><td colspan="6" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($appointments as $appointment) {
                    $html .= '<tr>';
                    $html .= '<td>' . $appointment->id . '</td>';
                    $html .= '<td>' . htmlspecialchars($appointment->patient_name) . '</td>';
                    $html .= '<td>' . htmlspecialchars($appointment->phone) . '</td>';
                    $html .= '<td>' . htmlspecialchars($appointment->clinic->name ?? 'N/A') . '</td>';
                    $html .= '<td>' . $appointment->appointment_date->format('d M Y') . '</td>';
                    $html .= '<td>' . ucfirst($appointment->status) . '</td>';
                    $html .= '</tr>';
                }
            }
            
            $html .= '</tbody></table></body></html>';
            
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="appointments_' . date('Y-m-d_His') . '.pdf"');
            
            echo $html;
            exit;
        }

        return redirect()->route('admin.appointments.index');
    }

    public function syncAppointmentToPatient(Appointment $appointment)
    {
        Patient::syncFromAppointment($appointment);
    }

    public function downloadSample($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($format === 'csv') {
            $filename = 'appointments_sample_template.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Patient Name', 'Phone', 'Email', 'Clinic ID', 'Appointment Date', 'Appointment Time', 'Reason', 'Status', 'Notes', 'Report Path']);
            fputcsv($handle, ['John Doe', '+880123456789', 'john.doe@example.com', '1', '2026-06-01', '10:00', 'General Consultation', 'pending', 'First appointment note', '']);

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'appointments_sample_template.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Patient Name</th><th>Phone</th><th>Email</th><th>Clinic ID</th><th>Appointment Date</th><th>Appointment Time</th><th>Reason</th><th>Status</th><th>Notes</th><th>Report Path</th></tr></thead>';
            echo '<tbody>';
            echo '<tr><td>John Doe</td><td>+880123456789</td><td>john.doe@example.com</td><td>1</td><td>2026-06-01</td><td>10:00</td><td>General Consultation</td><td>pending</td><td>First appointment note</td><td></td></tr>';
            echo '</tbody></table>';
            exit;
        }

        return redirect()->route('admin.appointments.index');
    }

    public function import(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt,xls,xlsx', 'max:2048'],
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $imported = 0;
        $errors = [];

        if (in_array($extension, ['csv', 'txt'])) {
            $handle = fopen($file->getRealPath(), 'r');
            $header = fgetcsv($handle);

            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) < 1 || empty($row[0])) {
                    continue;
                }

                try {
                    $appointment = Appointment::create([
                        'patient_name' => $row[0] ?? '',
                        'phone' => $row[1] ?? null,
                        'email' => $row[2] ?? null,
                        'clinic_id' => (int) ($row[3] ?? 0),
                        'appointment_date' => $row[4] ?? null,
                        'appointment_time' => $row[5] ?? null,
                        'reason' => $row[6] ?? null,
                        'status' => $row[7] ?? 'pending',
                        'notes' => $row[8] ?? null,
                        'report_path' => $row[9] ?? null,
                    ]);

                    if ($appointment->status === 'confirmed') {
                        $this->syncAppointmentToPatient($appointment);
                    }
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = 'Row with patient name "' . ($row[0] ?? 'Unknown') . '" failed: ' . $e->getMessage();
                }
            }

            fclose($handle);
        }

        if ($imported > 0) {
            $message = "Successfully imported {$imported} appointments.";
            if (count($errors) > 0) {
                $message .= ' ' . count($errors) . ' rows had errors.';
            }
            return redirect()->route('admin.appointments.index')->with('success', $message);
        }

        return redirect()->route('admin.appointments.index')->with('error', 'No data was imported. Please check your file format.');
    }
}
