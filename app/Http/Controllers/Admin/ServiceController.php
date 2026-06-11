<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $search = $request->string('search');

        $services = Service::when($search, fn ($query) => $query->where('title', 'like', '%'.$search.'%'))
            ->orderBy('sort_order')
            ->paginate(10)
            ->withQueryString();

        return view('admin.services.index', compact('services', 'search'));
    }

    public function create()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['required', 'string', 'max:50'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['required', 'string', 'max:50'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }

    public function export($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $services = Service::orderBy('sort_order')->get();

        if ($format === 'csv') {
            $filename = 'services_' . date('Y-m-d_His') . '.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Title', 'Description', 'Icon', 'Sort Order', 'Is Active']);

            if ($services->isEmpty()) {
                fputcsv($handle, ['No data available', '', '', '', '']);
            } else {
                foreach ($services as $service) {
                    fputcsv($handle, [
                        $service->title,
                        $service->description,
                        $service->icon,
                        $service->sort_order,
                        $service->is_active ? 'Yes' : 'No',
                    ]);
                }
            }

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'services_' . date('Y-m-d_His') . '.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Title</th><th>Description</th><th>Icon</th><th>Sort Order</th><th>Is Active</th></tr></thead>';
            echo '<tbody>';

            if ($services->isEmpty()) {
                echo '<tr><td colspan="5" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($services as $service) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($service->title) . '</td>';
                    echo '<td>' . htmlspecialchars($service->description) . '</td>';
                    echo '<td>' . htmlspecialchars($service->icon) . '</td>';
                    echo '<td>' . $service->sort_order . '</td>';
                    echo '<td>' . ($service->is_active ? 'Yes' : 'No') . '</td>';
                    echo '</tr>';
                }
            }

            echo '</tbody></table>';
            exit;
        }

        if ($format === 'pdf') {
            $html = '<html><head><style>body{font-family:Arial,sans-serif;font-size:12px;}table{width:100%;border-collapse:collapse;margin-top:20px;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f4f4f4;font-weight:bold;}h1{text-align:center;color:#333;}</style></head><body>';
            $html .= '<h1>Services Report</h1>';
            $html .= '<p>Generated on: ' . date('d M Y H:i:s') . '</p>';
            $html .= '<table><thead><tr><th>Title</th><th>Description</th><th>Icon</th><th>Sort Order</th><th>Is Active</th></tr></thead><tbody>';

            if ($services->isEmpty()) {
                $html .= '<tr><td colspan="5" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($services as $service) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($service->title) . '</td>';
                    $html .= '<td>' . htmlspecialchars($service->description) . '</td>';
                    $html .= '<td>' . htmlspecialchars($service->icon) . '</td>';
                    $html .= '<td>' . $service->sort_order . '</td>';
                    $html .= '<td>' . ($service->is_active ? 'Yes' : 'No') . '</td>';
                    $html .= '</tr>';
                }
            }

            $html .= '</tbody></table></body></html>';

            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="services_' . date('Y-m-d_His') . '.pdf"');

            echo $html;
            exit;
        }

        return redirect()->route('admin.services.index');
    }

    public function downloadSample($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($format === 'csv') {
            $filename = 'services_sample_template.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Title', 'Description', 'Icon', 'Sort Order', 'Is Active']);
            fputcsv($handle, ['General Consultation', 'Comprehensive health check-ups and advice.', 'stethoscope', '1', '1']);
            fputcsv($handle, ['Pediatrics', 'Specialized child healthcare services.', 'baby', '2', '1']);

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'services_sample_template.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Title</th><th>Description</th><th>Icon</th><th>Sort Order</th><th>Is Active</th></tr></thead>';
            echo '<tbody>';
            echo '<tr><td>General Consultation</td><td>Comprehensive health check-ups and advice.</td><td>stethoscope</td><td>1</td><td>1</td></tr>';
            echo '<tr><td>Pediatrics</td><td>Specialized child healthcare services.</td><td>baby</td><td>2</td><td>1</td></tr>';
            echo '</tbody></table>';
            exit;
        }

        return redirect()->route('admin.services.index');
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
                    Service::create([
                        'title' => $row[0] ?? '',
                        'description' => $row[1] ?? null,
                        'icon' => $row[2] ?? null,
                        'sort_order' => (int) ($row[3] ?? 0),
                        'is_active' => isset($row[4]) && in_array(strtolower(trim($row[4])), ['1', 'yes', 'true'], true),
                    ]);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = 'Row with title "' . ($row[0] ?? 'Unknown') . '" failed: ' . $e->getMessage();
                }
            }

            fclose($handle);
        }

        if ($imported > 0) {
            $message = "Successfully imported {$imported} services.";
            if (count($errors) > 0) {
                $message .= ' ' . count($errors) . ' rows had errors.';
            }
            return redirect()->route('admin.services.index')->with('success', $message);
        }

        return redirect()->route('admin.services.index')->with('error', 'No data was imported. Please check your file format.');
    }
}
