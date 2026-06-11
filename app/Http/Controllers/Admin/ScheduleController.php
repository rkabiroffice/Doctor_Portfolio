<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $search = $request->string('search');

        $schedules = Schedule::with('clinic')
            ->when($search, fn ($query) => $query->where('day_name', 'like', '%'.$search.'%'))
            ->orderBy('day_order')
            ->paginate(10)
            ->withQueryString();

        return view('admin.schedules.index', compact('schedules', 'search'));
    }

    public function create()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $clinics = Clinic::orderBy('name')->get();

        return view('admin.schedules.create', compact('clinics'));
    }

    public function store(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'clinic_id' => ['required', 'exists:clinics,id'],
            'day_name' => ['required', 'string', 'max:50'],
            'day_order' => ['required', 'integer', 'min:1', 'max:7'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'appointment_limit' => ['required', 'integer', 'min:1'],
            'is_closed' => ['nullable', 'boolean'],
        ]);

        $validated['is_closed'] = $request->boolean('is_closed');

        Schedule::create($validated);

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function edit(Schedule $schedule)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $clinics = Clinic::orderBy('name')->get();

        return view('admin.schedules.edit', compact('schedule', 'clinics'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'clinic_id' => ['required', 'exists:clinics,id'],
            'day_name' => ['required', 'string', 'max:50'],
            'day_order' => ['required', 'integer', 'min:1', 'max:7'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'appointment_limit' => ['required', 'integer', 'min:1'],
            'is_closed' => ['nullable', 'boolean'],
        ]);

        $validated['is_closed'] = $request->boolean('is_closed');

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule deleted successfully.');
    }

    public function export($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $schedules = Schedule::with('clinic')->orderBy('day_order')->get();

        if ($format === 'csv') {
            $filename = 'schedules_' . date('Y-m-d_His') . '.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Clinic ID', 'Clinic Name', 'Day Name', 'Day Order', 'Start Time', 'End Time', 'Appointment Limit', 'Is Closed']);

            if ($schedules->isEmpty()) {
                fputcsv($handle, ['No data available', '', '', '', '', '', '', '']);
            } else {
                foreach ($schedules as $schedule) {
                    fputcsv($handle, [
                        $schedule->clinic_id,
                        $schedule->clinic->name ?? '',
                        $schedule->day_name,
                        $schedule->day_order,
                        $schedule->start_time,
                        $schedule->end_time,
                        $schedule->appointment_limit,
                        $schedule->is_closed ? 'Yes' : 'No',
                    ]);
                }
            }

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'schedules_' . date('Y-m-d_His') . '.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Clinic ID</th><th>Clinic Name</th><th>Day Name</th><th>Day Order</th><th>Start Time</th><th>End Time</th><th>Appointment Limit</th><th>Is Closed</th></tr></thead>';
            echo '<tbody>';

            if ($schedules->isEmpty()) {
                echo '<tr><td colspan="8" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($schedules as $schedule) {
                    echo '<tr>';
                    echo '<td>' . $schedule->clinic_id . '</td>';
                    echo '<td>' . htmlspecialchars($schedule->clinic->name ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($schedule->day_name) . '</td>';
                    echo '<td>' . $schedule->day_order . '</td>';
                    echo '<td>' . htmlspecialchars($schedule->start_time) . '</td>';
                    echo '<td>' . htmlspecialchars($schedule->end_time) . '</td>';
                    echo '<td>' . $schedule->appointment_limit . '</td>';
                    echo '<td>' . ($schedule->is_closed ? 'Yes' : 'No') . '</td>';
                    echo '</tr>';
                }
            }

            echo '</tbody></table>';
            exit;
        }

        if ($format === 'pdf') {
            $html = '<html><head><style>body{font-family:Arial,sans-serif;font-size:12px;}table{width:100%;border-collapse:collapse;margin-top:20px;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f4f4f4;font-weight:bold;}h1{text-align:center;color:#333;}</style></head><body>';
            $html .= '<h1>Schedules Report</h1>';
            $html .= '<p>Generated on: ' . date('d M Y H:i:s') . '</p>';
            $html .= '<table><thead><tr><th>Clinic Name</th><th>Day Name</th><th>Day Order</th><th>Start Time</th><th>End Time</th><th>Appointment Limit</th><th>Is Closed</th></tr></thead><tbody>';

            if ($schedules->isEmpty()) {
                $html .= '<tr><td colspan="7" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($schedules as $schedule) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($schedule->clinic->name ?? 'N/A') . '</td>';
                    $html .= '<td>' . htmlspecialchars($schedule->day_name) . '</td>';
                    $html .= '<td>' . $schedule->day_order . '</td>';
                    $html .= '<td>' . htmlspecialchars($schedule->start_time) . '</td>';
                    $html .= '<td>' . htmlspecialchars($schedule->end_time) . '</td>';
                    $html .= '<td>' . $schedule->appointment_limit . '</td>';
                    $html .= '<td>' . ($schedule->is_closed ? 'Yes' : 'No') . '</td>';
                    $html .= '</tr>';
                }
            }

            $html .= '</tbody></table></body></html>';

            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="schedules_' . date('Y-m-d_His') . '.pdf"');

            echo $html;
            exit;
        }

        return redirect()->route('admin.schedules.index');
    }

    public function downloadSample($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($format === 'csv') {
            $filename = 'schedules_sample_template.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Clinic ID', 'Day Name', 'Day Order', 'Start Time', 'End Time', 'Appointment Limit', 'Is Closed']);
            fputcsv($handle, ['1', 'Monday', '1', '09:00', '17:00', '20', '0']);
            fputcsv($handle, ['1', 'Tuesday', '2', '09:00', '17:00', '20', '0']);

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'schedules_sample_template.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Clinic ID</th><th>Day Name</th><th>Day Order</th><th>Start Time</th><th>End Time</th><th>Appointment Limit</th><th>Is Closed</th></tr></thead>';
            echo '<tbody>';
            echo '<tr><td>1</td><td>Monday</td><td>1</td><td>09:00</td><td>17:00</td><td>20</td><td>0</td></tr>';
            echo '<tr><td>1</td><td>Tuesday</td><td>2</td><td>09:00</td><td>17:00</td><td>20</td><td>0</td></tr>';
            echo '</tbody></table>';
            exit;
        }

        return redirect()->route('admin.schedules.index');
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
                    Schedule::create([
                        'clinic_id' => (int) ($row[0] ?? 0),
                        'day_name' => $row[1] ?? '',
                        'day_order' => (int) ($row[2] ?? 0),
                        'start_time' => $row[3] ?? null,
                        'end_time' => $row[4] ?? null,
                        'appointment_limit' => (int) ($row[5] ?? 0),
                        'is_closed' => isset($row[6]) && in_array(strtolower(trim($row[6])), ['1', 'yes', 'true'], true),
                    ]);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = 'Row with clinic id "' . ($row[0] ?? 'Unknown') . '" failed: ' . $e->getMessage();
                }
            }

            fclose($handle);
        }

        if ($imported > 0) {
            $message = "Successfully imported {$imported} schedules.";
            if (count($errors) > 0) {
                $message .= ' ' . count($errors) . ' rows had errors.';
            }
            return redirect()->route('admin.schedules.index')->with('success', $message);
        }

        return redirect()->route('admin.schedules.index')->with('error', 'No data was imported. Please check your file format.');
    }
}
