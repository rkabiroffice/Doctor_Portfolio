<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\HeroSection;
use Illuminate\Http\Request;

class HeroSectionController extends Controller
{
    public function index(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $search = $request->string('search');

        $heroSections = HeroSection::when($search, fn ($query) => $query->where('title', 'like', '%'.$search.'%'))
            ->orderBy('sort_order')
            ->paginate(10)
            ->withQueryString();

        return view('admin.hero.index', compact('heroSections', 'search'));
    }

    public function create()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.hero.create');
    }

    public function store(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:500'],
            'subtitle' => ['nullable', 'string', 'max:1000'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'url'],
            'image_file' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image_url'] = Helper::storeUploadedImage($request, 'image_file', 'uploads/hero');
        }

        $validated['is_active'] = $request->boolean('is_active');

        HeroSection::create($validated);

        return redirect()->route('admin.hero.index')->with('success', 'Hero section created successfully.');
    }

    public function edit(HeroSection $heroSection)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.hero.edit', compact('heroSection'));
    }

    public function update(Request $request, HeroSection $heroSection)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:500'],
            'subtitle' => ['nullable', 'string', 'max:1000'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'url'],
            'image_file' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image_url'] = Helper::storeUploadedImage($request, 'image_file', 'uploads/hero');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $heroSection->update($validated);

        return redirect()->route('admin.hero.index')->with('success', 'Hero section updated successfully.');
    }

    public function destroy(HeroSection $heroSection)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $heroSection->delete();

        return redirect()->route('admin.hero.index')->with('success', 'Hero section deleted successfully.');
    }

    public function export($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $heroSections = HeroSection::orderBy('sort_order')->get();

        if ($format === 'csv') {
            $filename = 'hero_sections_' . date('Y-m-d_His') . '.csv';
            $handle = fopen('php://output', 'w');
            
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            fputcsv($handle, ['Title', 'Subtitle', 'Button Text', 'Button Link', 'Image URL', 'Sort Order', 'Is Active']);
            
            if ($heroSections->isEmpty()) {
                fputcsv($handle, ['No data available', '', '', '', '', '', '']);
            } else {
                foreach ($heroSections as $hero) {
                    fputcsv($handle, [
                        $hero->title,
                        $hero->subtitle ?? '',
                        $hero->button_text ?? '',
                        $hero->button_link ?? '',
                        $hero->image_url ?? '',
                        $hero->sort_order,
                        $hero->is_active ? 'Yes' : 'No'
                    ]);
                }
            }
            
            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'hero_sections_' . date('Y-m-d_His') . '.xls';
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            echo '<table border="1">';
            echo '<thead><tr><th>Title</th><th>Subtitle</th><th>Button Text</th><th>Button Link</th><th>Image URL</th><th>Sort Order</th><th>Is Active</th></tr></thead>';
            echo '<tbody>';
            
            if ($heroSections->isEmpty()) {
                echo '<tr><td colspan="7" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($heroSections as $hero) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($hero->title) . '</td>';
                    echo '<td>' . htmlspecialchars($hero->subtitle ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($hero->button_text ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($hero->button_link ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($hero->image_url ?? '') . '</td>';
                    echo '<td>' . $hero->sort_order . '</td>';
                    echo '<td>' . ($hero->is_active ? 'Yes' : 'No') . '</td>';
                    echo '</tr>';
                }
            }
            
            echo '</tbody></table>';
            exit;
        }

        if ($format === 'pdf') {
            $html = '<html><head><style>body{font-family:Arial,sans-serif;font-size:12px;}table{width:100%;border-collapse:collapse;margin-top:20px;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f4f4f4;font-weight:bold;}h1{text-align:center;color:#333;}</style></head><body>';
            $html .= '<h1>Hero Sections Report</h1>';
            $html .= '<p>Generated on: ' . date('d M Y H:i:s') . '</p>';
            $html .= '<table><thead><tr><th>Title</th><th>Subtitle</th><th>Button Text</th><th>Button Link</th><th>Sort Order</th><th>Active</th></tr></thead><tbody>';
            
            if ($heroSections->isEmpty()) {
                $html .= '<tr><td colspan="6" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($heroSections as $hero) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($hero->title) . '</td>';
                    $html .= '<td>' . htmlspecialchars($hero->subtitle ?? 'N/A') . '</td>';
                    $html .= '<td>' . htmlspecialchars($hero->button_text ?? 'N/A') . '</td>';
                    $html .= '<td>' . htmlspecialchars($hero->button_link ?? 'N/A') . '</td>';
                    $html .= '<td>' . $hero->sort_order . '</td>';
                    $html .= '<td>' . ($hero->is_active ? 'Yes' : 'No') . '</td>';
                    $html .= '</tr>';
                }
            }
            
            $html .= '</tbody></table></body></html>';
            
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="hero_sections_' . date('Y-m-d_His') . '.pdf"');
            
            echo $html;
            exit;
        }

        return redirect()->route('admin.hero.index');
    }

    public function downloadSample($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($format === 'csv') {
            $filename = 'hero_sections_sample_template.csv';
            $handle = fopen('php://output', 'w');
            
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            fputcsv($handle, ['Title', 'Subtitle', 'Button Text', 'Button Link', 'Image URL', 'Sort Order', 'Is Active']);
            fputcsv($handle, ['Welcome to Our Clinic', 'Professional healthcare services', 'Book Appointment', '/appointments', 'https://example.com/image.jpg', '1', '1']);
            fputcsv($handle, ['Expert Doctors', 'Meet our qualified medical professionals', 'View Doctors', '/doctors', 'https://example.com/image2.jpg', '2', '1']);
            
            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'hero_sections_sample_template.xls';
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            echo '<table border="1">';
            echo '<thead><tr><th>Title</th><th>Subtitle</th><th>Button Text</th><th>Button Link</th><th>Image URL</th><th>Sort Order</th><th>Is Active</th></tr></thead>';
            echo '<tbody>';
            echo '<tr><td>Welcome to Our Clinic</td><td>Professional healthcare services</td><td>Book Appointment</td><td>/appointments</td><td>https://example.com/image.jpg</td><td>1</td><td>1</td></tr>';
            echo '<tr><td>Expert Doctors</td><td>Meet our qualified medical professionals</td><td>View Doctors</td><td>/doctors</td><td>https://example.com/image2.jpg</td><td>2</td><td>1</td></tr>';
            echo '</tbody></table>';
            exit;
        }

        return redirect()->route('admin.hero.index');
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
                    HeroSection::create([
                        'title' => $row[0] ?? '',
                        'subtitle' => $row[1] ?? null,
                        'button_text' => $row[2] ?? null,
                        'button_link' => $row[3] ?? null,
                        'image_url' => $row[4] ?? null,
                        'sort_order' => (int) ($row[5] ?? 0),
                        'is_active' => isset($row[6]) && in_array(strtolower($row[6]), ['1', 'yes', 'true']),
                    ]);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = 'Row with title "' . ($row[0] ?? 'Unknown') . '" failed: ' . $e->getMessage();
                }
            }
            
            fclose($handle);
        }

        if ($imported > 0) {
            $message = "Successfully imported {$imported} hero sections.";
            if (count($errors) > 0) {
                $message .= ' ' . count($errors) . ' rows had errors.';
            }
            return redirect()->route('admin.hero.index')->with('success', $message);
        }

        return redirect()->route('admin.hero.index')->with('error', 'No data was imported. Please check your file format.');
    }
}
