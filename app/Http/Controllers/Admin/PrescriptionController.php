<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Models\Education;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\PrescriptionMedicine;
use App\Models\Setting;
use App\Services\ReportService;
use Illuminate\Http\Request;
use PDF;

class PrescriptionController extends Controller
{
    public function index(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $search = $request->string('search');

        $prescriptions = Prescription::with('appointment')
            ->when($search, fn ($query) => $query->where('diagnosis', 'like', '%'.$search.'%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.prescriptions.index', compact('prescriptions', 'search'));
    }

    public function create(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $appointmentId = $request->query('appointment_id');
        $appointments = Appointment::with('clinic.schedules', 'reports', 'patient')->latest()->get();
        $education = Education::orderBy('year_completed', 'asc')->get();
        $settings = Setting::pluck('value', 'key')->toArray();
        $doctorProfile = DoctorProfile::first();

        $selectedMedicineNames = [];
        $oldMedicines = old('medicines', []);
        if (is_array($oldMedicines) && count($oldMedicines) > 0) {
            $selectedIds = collect($oldMedicines)->pluck('medicine_id')->filter()->all();
            if (! empty($selectedIds)) {
                $selectedMedicineNames = Medicine::whereIn('id', $selectedIds)
                    ->get(['id', 'name', 'strength', 'generic_name', 'manufacturer'])
                    ->mapWithKeys(function ($medicine) {
                        $displayName = $medicine->name
                            ? $medicine->name . ($medicine->strength ? ' - ' . $medicine->strength : '')
                            : ($medicine->generic_name ?? '');

                        if (! $medicine->name && $medicine->manufacturer) {
                            $displayName .= ' - ' . $medicine->manufacturer;
                        }

                        return [$medicine->id => $displayName];
                    })
                    ->all();
            }
        }

        return view('admin.prescriptions.create', compact('appointments', 'appointmentId', 'settings', 'doctorProfile', 'education', 'selectedMedicineNames'));
    }

    public function store(Request $request, ReportService $reportService)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'appointment_id' => ['required', 'exists:appointments,id'],
            'chief_complaint' => ['nullable', 'string'],
            'on_examination' => ['nullable', 'string'],
            'bp' => ['nullable', 'string', 'max:50'],
            'pulse' => ['nullable', 'string', 'max:50'],
            'temperature' => ['nullable', 'string', 'max:50'],
            'height' => ['nullable', 'string', 'max:50'],
            'weight' => ['nullable', 'string', 'max:50'],
            'diagnosis' => ['required', 'string'],
            'advice' => ['nullable', 'string'],
            'follow_up_date' => ['nullable', 'date'],
            'medicines' => ['required', 'array', 'min:1'],
            'medicines.*.medicine_id' => ['required', 'exists:medicines,id'],
            'medicines.*.morning_dose' => ['nullable', 'string', 'max:50'],
            'medicines.*.afternoon_dose' => ['nullable', 'string', 'max:50'],
            'medicines.*.night_dose' => ['nullable', 'string', 'max:50'],
            'medicines.*.duration' => ['required', 'string', 'max:100'],
            'medicines.*.instruction' => ['nullable', 'string'],
            'reports' => ['nullable', 'array'],
            'reports.*' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,pdf', 'max:10240'],
        ]);

        $prescription = Prescription::create([
            'appointment_id' => $validated['appointment_id'],
            'chief_complaint' => $validated['chief_complaint'] ?? null,
            'on_examination' => $validated['on_examination'] ?? null,
            'bp' => $validated['bp'] ?? null,
            'pulse' => $validated['pulse'] ?? null,
            'temperature' => $validated['temperature'] ?? null,
            'height' => $validated['height'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'diagnosis' => $validated['diagnosis'],
            'advice' => $validated['advice'] ?? null,
            'follow_up_date' => $validated['follow_up_date'] ?? null,
        ]);

        foreach ($validated['medicines'] as $medicineData) {
            PrescriptionMedicine::create([
                'prescription_id' => $prescription->id,
                'medicine_id' => $medicineData['medicine_id'],
                'morning_dose' => $medicineData['morning_dose'],
                'afternoon_dose' => $medicineData['afternoon_dose'],
                'night_dose' => $medicineData['night_dose'],
                'duration' => $medicineData['duration'],
                'instruction' => $medicineData['instruction'],
            ]);
        }

        if ($request->hasFile('reports')) {
            $reportService->attachReports($request->file('reports') ?? [], $prescription);
        }

        $prescription->appointment->patient?->refreshStatus();

        return redirect()->route('admin.prescriptions.show', $prescription)->with('success', 'Prescription created successfully.');
    }

    public function edit(Prescription $prescription)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $prescription->load('appointment.clinic.schedules', 'prescriptionMedicines.medicine', 'reports');
        $appointments = Appointment::with('clinic.schedules', 'reports')->latest()->get();
        $education = Education::orderBy('year_completed', 'asc')->get();
        $settings = Setting::pluck('value', 'key')->toArray();
        $doctorProfile = DoctorProfile::first();

        $existingMedicines = $prescription->prescriptionMedicines->map(function ($item) {
            $displayName = $item->medicine?->name
                ? $item->medicine->name . ($item->medicine->strength ? ' - ' . $item->medicine->strength : '')
                : ($item->medicine?->generic_name ?? '');

            if (! $item->medicine?->name && $item->medicine?->manufacturer) {
                $displayName .= ' - ' . $item->medicine->manufacturer;
            }

            return [
                'medicine_id' => $item->medicine_id,
                'medicine_name' => $displayName,
                'morning_dose' => $item->morning_dose,
                'afternoon_dose' => $item->afternoon_dose,
                'night_dose' => $item->night_dose,
                'duration' => $item->duration,
                'instruction' => $item->instruction,
            ];
        })->toArray();

        $selectedMedicineNames = [];
        $oldMedicines = old('medicines', []);
        if (is_array($oldMedicines) && count($oldMedicines) > 0) {
            $selectedIds = collect($oldMedicines)->pluck('medicine_id')->filter()->all();
            if (! empty($selectedIds)) {
                $selectedMedicineNames = Medicine::whereIn('id', $selectedIds)
                    ->get(['id', 'name', 'strength', 'generic_name', 'manufacturer'])
                    ->mapWithKeys(function ($medicine) {
                        $displayName = $medicine->name
                            ? $medicine->name . ($medicine->strength ? ' - ' . $medicine->strength : '')
                            : ($medicine->generic_name ?? '');

                        if (! $medicine->name && $medicine->manufacturer) {
                            $displayName .= ' - ' . $medicine->manufacturer;
                        }

                        return [$medicine->id => $displayName];
                    })
                    ->all();
            }
        }

        return view('admin.prescriptions.edit', compact('prescription', 'appointments', 'settings', 'doctorProfile', 'education', 'existingMedicines', 'selectedMedicineNames'));
    }

    public function show(Prescription $prescription)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $prescription->load('appointment.clinic.schedules', 'appointment.patient', 'appointment.reports', 'prescriptionMedicines.medicine');
        $education = Education::orderBy('year_completed', 'asc')->get();
        $settings = Setting::pluck('value', 'key')->toArray();
        $doctorProfile = DoctorProfile::first();

        return view('admin.prescriptions.show', compact('prescription', 'settings', 'doctorProfile', 'education'));
    }

    public function update(Request $request, Prescription $prescription, ReportService $reportService)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'appointment_id' => ['required', 'exists:appointments,id'],
            'chief_complaint' => ['nullable', 'string'],
            'on_examination' => ['nullable', 'string'],
            'bp' => ['nullable', 'string', 'max:50'],
            'pulse' => ['nullable', 'string', 'max:50'],
            'temperature' => ['nullable', 'string', 'max:50'],
            'height' => ['nullable', 'string', 'max:50'],
            'weight' => ['nullable', 'string', 'max:50'],
            'diagnosis' => ['required', 'string'],
            'advice' => ['nullable', 'string'],
            'follow_up_date' => ['nullable', 'date'],
            'medicines' => ['required', 'array', 'min:1'],
            'medicines.*.medicine_id' => ['required', 'exists:medicines,id'],
            'medicines.*.morning_dose' => ['nullable', 'string', 'max:50'],
            'medicines.*.afternoon_dose' => ['nullable', 'string', 'max:50'],
            'medicines.*.night_dose' => ['nullable', 'string', 'max:50'],
            'medicines.*.duration' => ['required', 'string', 'max:100'],
            'medicines.*.instruction' => ['nullable', 'string'],
            'reports' => ['nullable', 'array'],
            'reports.*' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,pdf', 'max:10240'],
        ]);

        $prescription->update([
            'appointment_id' => $validated['appointment_id'],
            'chief_complaint' => $validated['chief_complaint'] ?? null,
            'on_examination' => $validated['on_examination'] ?? null,
            'bp' => $validated['bp'] ?? null,
            'pulse' => $validated['pulse'] ?? null,
            'temperature' => $validated['temperature'] ?? null,
            'height' => $validated['height'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'diagnosis' => $validated['diagnosis'],
            'advice' => $validated['advice'] ?? null,
            'follow_up_date' => $validated['follow_up_date'] ?? null,
        ]);

        $prescription->prescriptionMedicines()->delete();

        foreach ($validated['medicines'] as $medicineData) {
            PrescriptionMedicine::create([
                'prescription_id' => $prescription->id,
                'medicine_id' => $medicineData['medicine_id'],
                'morning_dose' => $medicineData['morning_dose'],
                'afternoon_dose' => $medicineData['afternoon_dose'],
                'night_dose' => $medicineData['night_dose'],
                'duration' => $medicineData['duration'],
                'instruction' => $medicineData['instruction'],
            ]);
        }

        if ($request->hasFile('reports')) {
            $reportService->attachReports($request->file('reports') ?? [], $prescription);
        }

        $prescription->appointment->patient?->refreshStatus();

        return redirect()->route('admin.prescriptions.show', $prescription)->with('success', 'Prescription updated successfully.');
        
    }

    public function destroy(Prescription $prescription, ReportService $reportService)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $appointmentId = $prescription->appointment_id;

        foreach ($prescription->reports as $report) {
            $reportService->deleteReport($report);
        }

        $appointment = $prescription->appointment;
        $prescription->delete();
        $appointment?->patient?->refreshStatus();

        return redirect()->route('admin.appointments.show', $appointmentId)->with('success', 'Prescription deleted successfully.');
    }

    public function downloadPdf(Prescription $prescription)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $prescription->load('appointment.clinic.schedules', 'appointment.patient', 'prescriptionMedicines.medicine');
        $education = Education::orderByDesc('year_completed')->get();
        $settings = Setting::pluck('value', 'key')->toArray();
        $doctorProfile = DoctorProfile::first();

        $config = [
            'format'           => 'A4',
            'orientation'      => 'P', // Portrait
            'default_font'     => 'banglafont', // Must match the key inside config/pdf.php
            'margin_left'      => 0,   // Set to 0 if your blade template already handles margins
            'margin_right'     => 0,
            'margin_top'       => 0,
            'margin_bottom'    => 0,
        ];

        // Load the view and pass data + custom mPDF config
        $pdf = PDF::loadView('admin.prescriptions.pdf', 
            compact('prescription', 'settings', 'doctorProfile', 'education'), 
            [], 
            $config
        );

        // Dynamic filename wrapper
        $fileName = 'prescription_' . str_pad($prescription->id, 6, '0', STR_PAD_LEFT) . '.pdf';

        return $pdf->download($fileName);
    }

    public function downloadSample($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($format === 'csv') {
            $filename = 'prescriptions_sample_template.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Appointment ID', 'Diagnosis', 'Advice', 'Follow-up Date']);
            fputcsv($handle, ['1', 'High blood pressure', 'Take rest and follow diet plan', '2026-06-10']);

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'prescriptions_sample_template.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Appointment ID</th><th>Diagnosis</th><th>Advice</th><th>Follow-up Date</th></tr></thead>';
            echo '<tbody>';
            echo '<tr><td>1</td><td>High blood pressure</td><td>Take rest and follow diet plan</td><td>2026-06-10</td></tr>';
            echo '</tbody></table>';
            exit;
        }

        return redirect()->route('admin.prescriptions.index');
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
                    Prescription::create([
                        'appointment_id' => (int) ($row[0] ?? 0),
                        'diagnosis' => $row[1] ?? null,
                        'advice' => $row[2] ?? null,
                        'follow_up_date' => $row[3] ?? null,
                    ]);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = 'Row with appointment ID "' . ($row[0] ?? 'Unknown') . '" failed: ' . $e->getMessage();
                }
            }

            fclose($handle);
        }

        if ($imported > 0) {
            $message = "Successfully imported {$imported} prescriptions.";
            if (count($errors) > 0) {
                $message .= ' ' . count($errors) . ' rows had errors.';
            }
            return redirect()->route('admin.prescriptions.index')->with('success', $message);
        }

        return redirect()->route('admin.prescriptions.index')->with('error', 'No data was imported. Please check your file format.');
    }

    public function export($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $prescriptions = Prescription::with('appointment')->latest()->get();

        if ($format === 'csv') {
            $filename = 'prescriptions_' . date('Y-m-d_His') . '.csv';
            $handle = fopen('php://output', 'w');
            
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            fputcsv($handle, ['ID', 'Patient Name', 'Diagnosis', 'Advice', 'Follow-up Date', 'Created Date']);
            
            if ($prescriptions->isEmpty()) {
                fputcsv($handle, ['No data available', '', '', '', '', '']);
            } else {
                foreach ($prescriptions as $prescription) {
                    fputcsv($handle, [
                        $prescription->id,
                        $prescription->appointment->patient_name ?? 'N/A',
                        $prescription->diagnosis,
                        $prescription->advice ?? '',
                        $prescription->follow_up_date ? $prescription->follow_up_date->format('Y-m-d') : '',
                        $prescription->created_at->format('Y-m-d')
                    ]);
                }
            }
            
            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'prescriptions_' . date('Y-m-d_His') . '.xls';
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            echo '<table border="1">';
            echo '<thead><tr><th>ID</th><th>Patient Name</th><th>Diagnosis</th><th>Advice</th><th>Follow-up Date</th><th>Created Date</th></tr></thead>';
            echo '<tbody>';
            
            if ($prescriptions->isEmpty()) {
                echo '<tr><td colspan="6" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($prescriptions as $prescription) {
                    echo '<tr>';
                    echo '<td>' . $prescription->id . '</td>';
                    echo '<td>' . htmlspecialchars($prescription->appointment->patient_name ?? 'N/A') . '</td>';
                    echo '<td>' . htmlspecialchars($prescription->diagnosis) . '</td>';
                    echo '<td>' . htmlspecialchars($prescription->advice ?? '') . '</td>';
                    echo '<td>' . ($prescription->follow_up_date ? $prescription->follow_up_date->format('Y-m-d') : '') . '</td>';
                    echo '<td>' . $prescription->created_at->format('Y-m-d') . '</td>';
                    echo '</tr>';
                }
            }
            
            echo '</tbody></table>';
            exit;
        }

        if ($format === 'pdf') {
            $html = '<html><head><style>body{font-family:Arial,sans-serif;font-size:12px;}table{width:100%;border-collapse:collapse;margin-top:20px;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f4f4f4;font-weight:bold;}h1{text-align:center;color:#333;}</style></head><body>';
            $html .= '<h1>Prescriptions Report</h1>';
            $html .= '<p>Generated on: ' . date('d M Y H:i:s') . '</p>';
            $html .= '<table><thead><tr><th>ID</th><th>Patient Name</th><th>Diagnosis</th><th>Advice</th><th>Follow-up Date</th><th>Created Date</th></tr></thead><tbody>';

            if ($prescriptions->isEmpty()) {
                $html .= '<tr><td colspan="6" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($prescriptions as $prescription) {
                    $html .= '<tr>';
                    $html .= '<td>' . $prescription->id . '</td>';
                    $html .= '<td>' . htmlspecialchars($prescription->appointment->patient_name ?? 'N/A') . '</td>';
                    $html .= '<td>' . htmlspecialchars($prescription->diagnosis) . '</td>';
                    $html .= '<td>' . htmlspecialchars($prescription->advice ?? '') . '</td>';
                    $html .= '<td>' . ($prescription->follow_up_date ? $prescription->follow_up_date->format('Y-m-d') : '') . '</td>';
                    $html .= '<td>' . $prescription->created_at->format('Y-m-d') . '</td>';
                    $html .= '</tr>';
                }
            }

            $html .= '</tbody></table></body></html>';

            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="prescriptions_' . date('Y-m-d_His') . '.pdf"');

            echo $html;
            exit;
        }

        return redirect()->route('admin.prescriptions.index');
    }
}
