<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\ContentSection;
use Illuminate\Http\Request;

class ContentSectionController extends Controller
{
    private array $sections = [
        'hero' => 'Hero Section',
        'about' => 'About Section',
        'bio' => 'Biography',
    ];

    public function index()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $contentSections = [];
        foreach ($this->sections as $key => $label) {
            $contentSections[$key] = ContentSection::firstOrCreate(
                ['section_key' => $key],
                ['section_label' => $label, 'title' => '', 'subtitle' => '', 'content' => '']
            );
        }

        return view('admin.content.index', compact('contentSections'));
    }

    public function update(Request $request, $section)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:500'],
            'subtitle' => ['nullable', 'string', 'max:1000'],
            'content' => ['nullable', 'string'],
            'image_url' => ['nullable', 'url'],
            'image_file' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image_url'] = Helper::storeUploadedImage($request, 'image_file', 'uploads/content');
        }

        $contentSection = ContentSection::where('section_key', $section)->firstOrFail();
        $contentSection->update($validated);

        return redirect()->route('admin.content.index')->with('success', ucfirst($section).' section updated successfully.');
    }

    public function export($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $contentSections = ContentSection::orderBy('section_key')->get();

        if ($format === 'csv') {
            $filename = 'content_sections_' . date('Y-m-d_His') . '.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Section Key', 'Section Label', 'Title', 'Subtitle', 'Content', 'Image URL']);

            if ($contentSections->isEmpty()) {
                fputcsv($handle, ['No data available', '', '', '', '', '']);
            } else {
                foreach ($contentSections as $section) {
                    fputcsv($handle, [
                        $section->section_key,
                        $section->section_label,
                        $section->title,
                        $section->subtitle ?? '',
                        $section->content ?? '',
                        $section->image_url ?? '',
                    ]);
                }
            }

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'content_sections_' . date('Y-m-d_His') . '.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Section Key</th><th>Section Label</th><th>Title</th><th>Subtitle</th><th>Content</th><th>Image URL</th></tr></thead>';
            echo '<tbody>';

            if ($contentSections->isEmpty()) {
                echo '<tr><td colspan="6" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($contentSections as $section) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($section->section_key) . '</td>';
                    echo '<td>' . htmlspecialchars($section->section_label) . '</td>';
                    echo '<td>' . htmlspecialchars($section->title) . '</td>';
                    echo '<td>' . htmlspecialchars($section->subtitle ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($section->content ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($section->image_url ?? '') . '</td>';
                    echo '</tr>';
                }
            }

            echo '</tbody></table>';
            exit;
        }

        if ($format === 'pdf') {
            $html = '<html><head><style>body{font-family:Arial,sans-serif;font-size:12px;}table{width:100%;border-collapse:collapse;margin-top:20px;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f4f4f4;font-weight:bold;}h1{text-align:center;color:#333;}</style></head><body>';
            $html .= '<h1>Content Sections Report</h1>';
            $html .= '<p>Generated on: ' . date('d M Y H:i:s') . '</p>';
            $html .= '<table><thead><tr><th>Section Key</th><th>Section Label</th><th>Title</th><th>Subtitle</th><th>Image URL</th></tr></thead><tbody>';

            if ($contentSections->isEmpty()) {
                $html .= '<tr><td colspan="5" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($contentSections as $section) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($section->section_key) . '</td>';
                    $html .= '<td>' . htmlspecialchars($section->section_label) . '</td>';
                    $html .= '<td>' . htmlspecialchars($section->title) . '</td>';
                    $html .= '<td>' . htmlspecialchars($section->subtitle ?? 'N/A') . '</td>';
                    $html .= '<td>' . htmlspecialchars($section->image_url ?? 'N/A') . '</td>';
                    $html .= '</tr>';
                }
            }

            $html .= '</tbody></table></body></html>';

            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="content_sections_' . date('Y-m-d_His') . '.pdf"');

            echo $html;
            exit;
        }

        return redirect()->route('admin.content.index');
    }

    public function downloadSample($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($format === 'csv') {
            $filename = 'content_sections_sample_template.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Section Key', 'Section Label', 'Title', 'Subtitle', 'Content', 'Image URL']);
            fputcsv($handle, ['hero', 'Hero Section', 'Welcome to Your Health Journey', 'Trusted primary care for families.', 'This is the hero content for the main page.', 'https://example.com/hero.jpg']);
            fputcsv($handle, ['about', 'About Section', 'Meet Our Team', 'Experienced specialists dedicated to your care.', 'About us section content that highlights values and services.', 'https://example.com/about.jpg']);

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'content_sections_sample_template.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Section Key</th><th>Section Label</th><th>Title</th><th>Subtitle</th><th>Content</th><th>Image URL</th></tr></thead>';
            echo '<tbody>';
            echo '<tr><td>hero</td><td>Hero Section</td><td>Welcome to Your Health Journey</td><td>Trusted primary care for families.</td><td>This is the hero content for the main page.</td><td>https://example.com/hero.jpg</td></tr>';
            echo '<tr><td>about</td><td>About Section</td><td>Meet Our Team</td><td>Experienced specialists dedicated to your care.</td><td>About us section content that highlights values and services.</td><td>https://example.com/about.jpg</td></tr>';
            echo '</tbody></table>';
            exit;
        }

        return redirect()->route('admin.content.index');
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
                    ContentSection::create([
                        'section_key' => $row[0] ?? '',
                        'section_label' => $row[1] ?? null,
                        'title' => $row[2] ?? null,
                        'subtitle' => $row[3] ?? null,
                        'content' => $row[4] ?? null,
                        'image_url' => $row[5] ?? null,
                    ]);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = 'Row with section key "' . ($row[0] ?? 'Unknown') . '" failed: ' . $e->getMessage();
                }
            }

            fclose($handle);
        }

        if ($imported > 0) {
            $message = "Successfully imported {$imported} content sections.";
            if (count($errors) > 0) {
                $message .= ' ' . count($errors) . ' rows had errors.';
            }
            return redirect()->route('admin.content.index')->with('success', $message);
        }

        return redirect()->route('admin.content.index')->with('error', 'No data was imported. Please check your file format.');
    }
}
