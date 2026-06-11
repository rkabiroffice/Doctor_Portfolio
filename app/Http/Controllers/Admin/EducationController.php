<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $search = $request->string('search');

        $educationItems = Education::when($search, fn ($query) => $query->where('degree', 'like', '%'.$search.'%')->orWhere('institution', 'like', '%'.$search.'%'))
            ->orderByDesc('year_completed')
            ->paginate(10)
            ->withQueryString();

        return view('admin.education.index', compact('educationItems', 'search'));
    }

    public function create()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.education.create');
    }

    public function store(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'degree' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'year_completed' => ['required', 'integer', 'min:1950', 'max:2100'],
            'details' => ['nullable', 'string'],
            'type' => ['required', 'string', 'max:100'],
        ]);

        Education::create($validated);

        return redirect()->route('admin.education.index')->with('success', 'Education item added successfully.');
    }

    public function edit(Education $education)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.education.edit', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'degree' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'year_completed' => ['required', 'integer', 'min:1950', 'max:2100'],
            'details' => ['nullable', 'string'],
            'type' => ['required', 'string', 'max:100'],
        ]);

        $education->update($validated);

        return redirect()->route('admin.education.index')->with('success', 'Education item updated successfully.');
    }

    public function destroy(Education $education)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $education->delete();

        return redirect()->route('admin.education.index')->with('success', 'Education item deleted successfully.');
    }

    public function export($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $educationItems = Education::orderByDesc('year_completed')->get();

        if ($format === 'csv') {
            $filename = 'education_' . date('Y-m-d_His') . '.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Degree', 'Institution', 'Year Completed', 'Details', 'Type']);

            if ($educationItems->isEmpty()) {
                fputcsv($handle, ['No data available', '', '', '', '']);
            } else {
                foreach ($educationItems as $item) {
                    fputcsv($handle, [
                        $item->degree,
                        $item->institution,
                        $item->year_completed,
                        $item->details ?? '',
                        $item->type,
                    ]);
                }
            }

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'education_' . date('Y-m-d_His') . '.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Degree</th><th>Institution</th><th>Year Completed</th><th>Details</th><th>Type</th></tr></thead>';
            echo '<tbody>';

            if ($educationItems->isEmpty()) {
                echo '<tr><td colspan="5" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($educationItems as $item) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($item->degree) . '</td>';
                    echo '<td>' . htmlspecialchars($item->institution) . '</td>';
                    echo '<td>' . $item->year_completed . '</td>';
                    echo '<td>' . htmlspecialchars($item->details ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($item->type) . '</td>';
                    echo '</tr>';
                }
            }

            echo '</tbody></table>';
            exit;
        }

        if ($format === 'pdf') {
            $html = '<html><head><style>body{font-family:Arial,sans-serif;font-size:12px;}table{width:100%;border-collapse:collapse;margin-top:20px;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f4f4f4;font-weight:bold;}h1{text-align:center;color:#333;}</style></head><body>';
            $html .= '<h1>Education Report</h1>';
            $html .= '<p>Generated on: ' . date('d M Y H:i:s') . '</p>';
            $html .= '<table><thead><tr><th>Degree</th><th>Institution</th><th>Year Completed</th><th>Details</th><th>Type</th></tr></thead><tbody>';

            if ($educationItems->isEmpty()) {
                $html .= '<tr><td colspan="5" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($educationItems as $item) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($item->degree) . '</td>';
                    $html .= '<td>' . htmlspecialchars($item->institution) . '</td>';
                    $html .= '<td>' . $item->year_completed . '</td>';
                    $html .= '<td>' . htmlspecialchars($item->details ?? 'N/A') . '</td>';
                    $html .= '<td>' . htmlspecialchars($item->type) . '</td>';
                    $html .= '</tr>';
                }
            }

            $html .= '</tbody></table></body></html>';

            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="education_' . date('Y-m-d_His') . '.pdf"');

            echo $html;
            exit;
        }

        return redirect()->route('admin.education.index');
    }

    public function downloadSample($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($format === 'csv') {
            $filename = 'education_sample_template.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Degree', 'Institution', 'Year Completed', 'Details', 'Type']);
            fputcsv($handle, ['MBBS', 'National Medical College', '2010', 'General medicine qualification', 'Medical']);
            fputcsv($handle, ['MSc in Public Health', 'Dhaka University', '2015', 'Specialization in public health', 'Postgraduate']);

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'education_sample_template.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Degree</th><th>Institution</th><th>Year Completed</th><th>Details</th><th>Type</th></tr></thead>';
            echo '<tbody>';
            echo '<tr><td>MBBS</td><td>National Medical College</td><td>2010</td><td>General medicine qualification</td><td>Medical</td></tr>';
            echo '<tr><td>MSc in Public Health</td><td>Dhaka University</td><td>2015</td><td>Specialization in public health</td><td>Postgraduate</td></tr>';
            echo '</tbody></table>';
            exit;
        }

        return redirect()->route('admin.education.index');
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
                    Education::create([
                        'degree' => $row[0] ?? '',
                        'institution' => $row[1] ?? null,
                        'year_completed' => (int) ($row[2] ?? 0),
                        'details' => $row[3] ?? null,
                        'type' => $row[4] ?? null,
                    ]);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = 'Row with degree "' . ($row[0] ?? 'Unknown') . '" failed: ' . $e->getMessage();
                }
            }

            fclose($handle);
        }

        if ($imported > 0) {
            $message = "Successfully imported {$imported} education items.";
            if (count($errors) > 0) {
                $message .= ' ' . count($errors) . ' rows had errors.';
            }
            return redirect()->route('admin.education.index')->with('success', $message);
        }

        return redirect()->route('admin.education.index')->with('error', 'No data was imported. Please check your file format.');
    }
}
