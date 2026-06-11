<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use Illuminate\Http\Request;

class AboutSectionController extends Controller
{
    public function index(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $search = $request->string('search');

        $aboutSections = AboutSection::when($search, fn ($query) => $query->where('title', 'like', '%'.$search.'%'))
            ->orderBy('sort_order')
            ->paginate(10)
            ->withQueryString();

        return view('admin.about.index', compact('aboutSections', 'search'));
    }

    public function create()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.about.create');
    }

    public function store(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:500'],
            'subtitle' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'image_url' => ['nullable', 'url'],
            'image_file' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image_url'] = Helper::storeUploadedImage($request, 'image_file', 'uploads/about');
        }

        $validated['is_active'] = $request->boolean('is_active');

        AboutSection::create($validated);

        return redirect()->route('admin.about.index')->with('success', 'About section created successfully.');
    }

    public function edit(AboutSection $aboutSection)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.about.edit', compact('aboutSection'));
    }

    public function update(Request $request, AboutSection $aboutSection)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:500'],
            'subtitle' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'image_url' => ['nullable', 'url'],
            'image_file' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image_url'] = Helper::storeUploadedImage($request, 'image_file', 'uploads/about');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $aboutSection->update($validated);

        return redirect()->route('admin.about.index')->with('success', 'About section updated successfully.');
    }

    public function destroy(AboutSection $aboutSection)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $aboutSection->delete();

        return redirect()->route('admin.about.index')->with('success', 'About section deleted successfully.');
    }

    public function export($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $aboutSections = AboutSection::orderBy('sort_order')->get();

        if ($format === 'csv') {
            $filename = 'about_sections_' . date('Y-m-d_His') . '.csv';
            $handle = fopen('php://output', 'w');
            
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            fputcsv($handle, ['Title', 'Subtitle', 'Content', 'Image URL', 'Sort Order', 'Is Active']);
            
            if ($aboutSections->isEmpty()) {
                fputcsv($handle, ['No data available', '', '', '', '', '']);
            } else {
                foreach ($aboutSections as $about) {
                    fputcsv($handle, [
                        $about->title,
                        $about->subtitle ?? '',
                        $about->content ?? '',
                        $about->image_url ?? '',
                        $about->sort_order,
                        $about->is_active ? 'Yes' : 'No'
                    ]);
                }
            }
            
            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'about_sections_' . date('Y-m-d_His') . '.xls';
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            echo '<table border="1">';
            echo '<thead><tr><th>Title</th><th>Subtitle</th><th>Content</th><th>Image URL</th><th>Sort Order</th><th>Is Active</th></tr></thead>';
            echo '<tbody>';
            
            if ($aboutSections->isEmpty()) {
                echo '<tr><td colspan="6" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($aboutSections as $about) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($about->title) . '</td>';
                    echo '<td>' . htmlspecialchars($about->subtitle ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($about->content ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($about->image_url ?? '') . '</td>';
                    echo '<td>' . $about->sort_order . '</td>';
                    echo '<td>' . ($about->is_active ? 'Yes' : 'No') . '</td>';
                    echo '</tr>';
                }
            }
            
            echo '</tbody></table>';
            exit;
        }

        if ($format === 'pdf') {
            $html = '<html><head><style>body{font-family:Arial,sans-serif;font-size:12px;}table{width:100%;border-collapse:collapse;margin-top:20px;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f4f4f4;font-weight:bold;}h1{text-align:center;color:#333;}</style></head><body>';
            $html .= '<h1>About Sections Report</h1>';
            $html .= '<p>Generated on: ' . date('d M Y H:i:s') . '</p>';
            $html .= '<table><thead><tr><th>Title</th><th>Subtitle</th><th>Content</th><th>Sort Order</th><th>Active</th></tr></thead><tbody>';
            
            if ($aboutSections->isEmpty()) {
                $html .= '<tr><td colspan="5" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($aboutSections as $about) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($about->title) . '</td>';
                    $html .= '<td>' . htmlspecialchars($about->subtitle ?? 'N/A') . '</td>';
                    $html .= '<td>' . htmlspecialchars(substr($about->content ?? 'N/A', 0, 100)) . '</td>';
                    $html .= '<td>' . $about->sort_order . '</td>';
                    $html .= '<td>' . ($about->is_active ? 'Yes' : 'No') . '</td>';
                    $html .= '</tr>';
                }
            }
            
            $html .= '</tbody></table></body></html>';
            
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="about_sections_' . date('Y-m-d_His') . '.pdf"');
            
            echo $html;
            exit;
        }

        return redirect()->route('admin.about.index');
    }

    public function downloadSample($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($format === 'csv') {
            $filename = 'about_sections_sample_template.csv';
            $handle = fopen('php://output', 'w');
            
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            fputcsv($handle, ['Title', 'Subtitle', 'Content', 'Image URL', 'Sort Order', 'Is Active']);
            fputcsv($handle, ['About Our Clinic', 'Professional Healthcare', 'We provide comprehensive medical services...', 'https://example.com/image.jpg', '1', '1']);
            fputcsv($handle, ['Our Mission', 'Caring for Patients', 'Our mission is to deliver quality healthcare...', 'https://example.com/image2.jpg', '2', '1']);
            
            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'about_sections_sample_template.xls';
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            echo '<table border="1">';
            echo '<thead><tr><th>Title</th><th>Subtitle</th><th>Content</th><th>Image URL</th><th>Sort Order</th><th>Is Active</th></tr></thead>';
            echo '<tbody>';
            echo '<tr><td>About Our Clinic</td><td>Professional Healthcare</td><td>We provide comprehensive medical services...</td><td>https://example.com/image.jpg</td><td>1</td><td>1</td></tr>';
            echo '<tr><td>Our Mission</td><td>Caring for Patients</td><td>Our mission is to deliver quality healthcare...</td><td>https://example.com/image2.jpg</td><td>2</td><td>1</td></tr>';
            echo '</tbody></table>';
            exit;
        }

        return redirect()->route('admin.about.index');
    }

    public function import(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt,xls,xlsx', 'max:2048']
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        
        $imported = 0;
        $errors = [];

        if (in_array($extension, ['csv', 'txt'])) {
            $handle = fopen($file->getRealPath(), 'r');
            $header = fgetcsv($handle);
            
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) < 1 || empty($row[0])) continue;
                
                try {
                    AboutSection::create([
                        'title' => $row[0] ?? '',
                        'subtitle' => $row[1] ?? null,
                        'content' => $row[2] ?? null,
                        'image_url' => $row[3] ?? null,
                        'sort_order' => (int) ($row[4] ?? 0),
                        'is_active' => isset($row[5]) && in_array(strtolower($row[5]), ['1', 'yes', 'true']),
                    ]);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = 'Row with title "' . ($row[0] ?? 'Unknown') . '" failed: ' . $e->getMessage();
                }
            }
            
            fclose($handle);
        }

        if ($imported > 0) {
            $message = "Successfully imported {$imported} about sections.";
            if (count($errors) > 0) {
                $message .= ' ' . count($errors) . ' rows had errors.';
            }
            return redirect()->route('admin.about.index')->with('success', $message);
        }

        return redirect()->route('admin.about.index')->with('error', 'No data was imported. Please check your file format.');
    }
}
