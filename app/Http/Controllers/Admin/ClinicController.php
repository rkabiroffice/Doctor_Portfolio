<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function index(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $search = $request->string('search');

        $clinics = Clinic::when($search, fn ($query) => $query->where('name', 'like', '%'.$search.'%')->orWhere('city', 'like', '%'.$search.'%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.clinics.index', compact('clinics', 'search'));
    }

    public function create()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.clinics.create');
    }

    public function store(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string', 'max:100'],
            'phones' => ['required', 'array', 'min:1'],
            'phones.*' => ['required', 'string', 'max:50'],
            'map_embed_url' => ['nullable', 'url'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if (! empty($validated['map_embed_url'])) {
            $validated['map_embed_url'] = Helper::normalizeGoogleMapsEmbedUrl($validated['map_embed_url']);
        }

        Clinic::create($validated);

        return redirect()->route('admin.clinics.index')->with('success', 'Clinic created successfully.');
    }

    public function edit(Clinic $clinic)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.clinics.edit', compact('clinic'));
    }

    public function update(Request $request, Clinic $clinic)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string', 'max:100'],
            'phones' => ['required', 'array', 'min:1'],
            'phones.*' => ['required', 'string', 'max:50'],
            'map_embed_url' => ['nullable', 'url'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if (! empty($validated['map_embed_url'])) {
            $validated['map_embed_url'] = Helper::normalizeGoogleMapsEmbedUrl($validated['map_embed_url']);
        }

        $clinic->update($validated);

        return redirect()->route('admin.clinics.index')->with('success', 'Clinic updated successfully.');
    }

    public function destroy(Clinic $clinic)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $clinic->delete();

        return redirect()->route('admin.clinics.index')->with('success', 'Clinic deleted successfully.');
    }

    public function export($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $clinics = Clinic::orderBy('name')->get();

        if ($format === 'csv') {
            $filename = 'clinics_' . date('Y-m-d_His') . '.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Name', 'Address', 'City', 'Phones', 'Map Embed URL', 'Is Active']);

            if ($clinics->isEmpty()) {
                fputcsv($handle, ['No data available', '', '', '', '', '']);
            } else {
                foreach ($clinics as $clinic) {
                    fputcsv($handle, [
                        $clinic->name,
                        $clinic->address,
                        $clinic->city,
                        implode(', ', $clinic->phones ?? []),
                        $clinic->map_embed_url ?? '',
                        $clinic->is_active ? 'Yes' : 'No',
                    ]);
                }
            }

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'clinics_' . date('Y-m-d_His') . '.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Name</th><th>Address</th><th>City</th><th>Phones</th><th>Map Embed URL</th><th>Is Active</th></tr></thead>';
            echo '<tbody>';

            if ($clinics->isEmpty()) {
                echo '<tr><td colspan="6" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($clinics as $clinic) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($clinic->name) . '</td>';
                    echo '<td>' . htmlspecialchars($clinic->address) . '</td>';
                    echo '<td>' . htmlspecialchars($clinic->city) . '</td>';
                    echo '<td>' . htmlspecialchars(implode(', ', $clinic->phones ?? [])) . '</td>';
                    echo '<td>' . htmlspecialchars($clinic->map_embed_url ?? '') . '</td>';
                    echo '<td>' . ($clinic->is_active ? 'Yes' : 'No') . '</td>';
                    echo '</tr>';
                }
            }

            echo '</tbody></table>';
            exit;
        }

        if ($format === 'pdf') {
            $html = '<html><head><style>body{font-family:Arial,sans-serif;font-size:12px;}table{width:100%;border-collapse:collapse;margin-top:20px;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f4f4f4;font-weight:bold;}h1{text-align:center;color:#333;}</style></head><body>';
            $html .= '<h1>Clinics Report</h1>';
            $html .= '<p>Generated on: ' . date('d M Y H:i:s') . '</p>';
            $html .= '<table><thead><tr><th>Name</th><th>Address</th><th>City</th><th>Phones</th><th>Map URL</th><th>Is Active</th></tr></thead><tbody>';

            if ($clinics->isEmpty()) {
                $html .= '<tr><td colspan="6" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($clinics as $clinic) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($clinic->name) . '</td>';
                    $html .= '<td>' . htmlspecialchars($clinic->address) . '</td>';
                    $html .= '<td>' . htmlspecialchars($clinic->city) . '</td>';
                    $html .= '<td>' . htmlspecialchars(implode(', ', $clinic->phones ?? [])) . '</td>';
                    $html .= '<td>' . htmlspecialchars($clinic->map_embed_url ?? 'N/A') . '</td>';
                    $html .= '<td>' . ($clinic->is_active ? 'Yes' : 'No') . '</td>';
                    $html .= '</tr>';
                }
            }

            $html .= '</tbody></table></body></html>';

            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="clinics_' . date('Y-m-d_His') . '.pdf"');

            echo $html;
            exit;
        }

        return redirect()->route('admin.clinics.index');
    }

    public function downloadSample($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($format === 'csv') {
            $filename = 'clinics_sample_template.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Name', 'Address', 'City', 'Phones', 'Map Embed URL', 'Is Active']);
            fputcsv($handle, ['Green Valley Clinic', '123 Wellness Road', 'Dhaka', '+880123456789, +880123456790', 'https://maps.google.com/?q=Green+Valley+Clinic', '1']);
            fputcsv($handle, ['Sunrise Health Center', '45 Sunrise Ave', 'Chittagong', '+880987654321', 'https://maps.google.com/?q=Sunrise+Health+Center', '1']);

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'clinics_sample_template.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Name</th><th>Address</th><th>City</th><th>Phones</th><th>Map Embed URL</th><th>Is Active</th></tr></thead>';
            echo '<tbody>';
            echo '<tr><td>Green Valley Clinic</td><td>123 Wellness Road</td><td>Dhaka</td><td>+880123456789, +880123456790</td><td>https://maps.google.com/?q=Green+Valley+Clinic</td><td>1</td></tr>';
            echo '<tr><td>Sunrise Health Center</td><td>45 Sunrise Ave</td><td>Chittagong</td><td>+880987654321</td><td>https://maps.google.com/?q=Sunrise+Health+Center</td><td>1</td></tr>';
            echo '</tbody></table>';
            exit;
        }

        return redirect()->route('admin.clinics.index');
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
                    Clinic::create([
                        'name' => $row[0] ?? '',
                        'address' => $row[1] ?? null,
                        'city' => $row[2] ?? null,
                        'phones' => isset($row[3]) && !empty($row[3]) ? explode(',', $row[3]) : [],
                        'map_embed_url' => $row[4] ?? null,
                        'is_active' => isset($row[5]) && in_array(strtolower(trim($row[5])), ['1', 'yes', 'true'], true),
                    ]);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = 'Row with clinic name "' . ($row[0] ?? 'Unknown') . '" failed: ' . $e->getMessage();
                }
            }

            fclose($handle);
        }

        if ($imported > 0) {
            $message = "Successfully imported {$imported} clinics.";
            if (count($errors) > 0) {
                $message .= ' ' . count($errors) . ' rows had errors.';
            }
            return redirect()->route('admin.clinics.index')->with('success', $message);
        }

        return redirect()->route('admin.clinics.index')->with('error', 'No data was imported. Please check your file format.');
    }
}
