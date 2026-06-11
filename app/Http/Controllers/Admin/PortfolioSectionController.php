<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioSection;
use Illuminate\Http\Request;

class PortfolioSectionController extends Controller
{
    public function index(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $search = $request->string('search');

        $sections = PortfolioSection::when($search, fn ($query) => $query
            ->where('title', 'like', '%'.$search.'%')
            ->orWhere('section_key', 'like', '%'.$search.'%'))
            ->orderBy('sort_order')
            ->paginate(10)
            ->withQueryString();

        return view('admin.sections.index', compact('sections', 'search'));
    }

    public function create()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.sections.create');
    }

    public function store(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'section_key' => ['required', 'string', 'max:100', 'unique:portfolio_sections,section_key'],
            'label' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        PortfolioSection::create($validated);

        return redirect()->route('admin.sections.index')->with('success', 'Portfolio section created successfully.');
    }

    public function edit(PortfolioSection $portfolioSection)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.sections.edit', ['section' => $portfolioSection]);
    }

    public function update(Request $request, PortfolioSection $portfolioSection)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'section_key' => ['required', 'string', 'max:100', 'unique:portfolio_sections,section_key,'.$portfolioSection->id],
            'label' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $portfolioSection->update($validated);

        return redirect()->route('admin.sections.index')->with('success', 'Portfolio section updated successfully.');
    }

    public function destroy(PortfolioSection $portfolioSection)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $portfolioSection->delete();

        return redirect()->route('admin.sections.index')->with('success', 'Portfolio section deleted successfully.');
    }

    public function export($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $sections = PortfolioSection::orderBy('sort_order')->get();

        if ($format === 'csv') {
            $filename = 'portfolio_sections_' . date('Y-m-d_His') . '.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Section Key', 'Label', 'Title', 'Subtitle', 'Content', 'Button Text', 'Button Link', 'Sort Order', 'Is Active']);

            if ($sections->isEmpty()) {
                fputcsv($handle, ['No data available', '', '', '', '', '', '', '', '']);
            } else {
                foreach ($sections as $section) {
                    fputcsv($handle, [
                        $section->section_key,
                        $section->label,
                        $section->title,
                        $section->subtitle ?? '',
                        $section->content ?? '',
                        $section->button_text ?? '',
                        $section->button_link ?? '',
                        $section->sort_order,
                        $section->is_active ? 'Yes' : 'No',
                    ]);
                }
            }

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'portfolio_sections_' . date('Y-m-d_His') . '.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Section Key</th><th>Label</th><th>Title</th><th>Subtitle</th><th>Content</th><th>Button Text</th><th>Button Link</th><th>Sort Order</th><th>Is Active</th></tr></thead>';
            echo '<tbody>';

            if ($sections->isEmpty()) {
                echo '<tr><td colspan="9" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($sections as $section) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($section->section_key) . '</td>';
                    echo '<td>' . htmlspecialchars($section->label) . '</td>';
                    echo '<td>' . htmlspecialchars($section->title) . '</td>';
                    echo '<td>' . htmlspecialchars($section->subtitle ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($section->content ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($section->button_text ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($section->button_link ?? '') . '</td>';
                    echo '<td>' . $section->sort_order . '</td>';
                    echo '<td>' . ($section->is_active ? 'Yes' : 'No') . '</td>';
                    echo '</tr>';
                }
            }

            echo '</tbody></table>';
            exit;
        }

        if ($format === 'pdf') {
            $html = '<html><head><style>body{font-family:Arial,sans-serif;font-size:12px;}table{width:100%;border-collapse:collapse;margin-top:20px;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f4f4f4;font-weight:bold;}h1{text-align:center;color:#333;}</style></head><body>';
            $html .= '<h1>Portfolio Sections Report</h1>';
            $html .= '<p>Generated on: ' . date('d M Y H:i:s') . '</p>';
            $html .= '<table><thead><tr><th>Section Key</th><th>Label</th><th>Title</th><th>Subtitle</th><th>Content</th><th>Button Text</th><th>Button Link</th><th>Sort Order</th><th>Is Active</th></tr></thead><tbody>';

            if ($sections->isEmpty()) {
                $html .= '<tr><td colspan="9" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($sections as $section) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($section->section_key) . '</td>';
                    $html .= '<td>' . htmlspecialchars($section->label) . '</td>';
                    $html .= '<td>' . htmlspecialchars($section->title) . '</td>';
                    $html .= '<td>' . htmlspecialchars($section->subtitle ?? 'N/A') . '</td>';
                    $html .= '<td>' . htmlspecialchars($section->content ?? 'N/A') . '</td>';
                    $html .= '<td>' . htmlspecialchars($section->button_text ?? 'N/A') . '</td>';
                    $html .= '<td>' . htmlspecialchars($section->button_link ?? 'N/A') . '</td>';
                    $html .= '<td>' . $section->sort_order . '</td>';
                    $html .= '<td>' . ($section->is_active ? 'Yes' : 'No') . '</td>';
                    $html .= '</tr>';
                }
            }

            $html .= '</tbody></table></body></html>';

            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="portfolio_sections_' . date('Y-m-d_His') . '.pdf"');

            echo $html;
            exit;
        }

        return redirect()->route('admin.sections.index');
    }

    public function downloadSample($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($format === 'csv') {
            $filename = 'portfolio_sections_sample_template.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Section Key', 'Label', 'Title', 'Subtitle', 'Content', 'Button Text', 'Button Link', 'Sort Order', 'Is Active']);
            fputcsv($handle, ['hero', 'Hero Section', 'Welcome to Our Clinic', 'World-class care for your family', 'This section introduces the clinic with a hero message.', 'Book Now', '/book', '1', '1']);
            fputcsv($handle, ['services', 'Services Section', 'Our Services', 'Expert care in every specialty', 'Describe your services clearly and concisely.', 'Learn More', '/services', '2', '1']);

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'portfolio_sections_sample_template.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Section Key</th><th>Label</th><th>Title</th><th>Subtitle</th><th>Content</th><th>Button Text</th><th>Button Link</th><th>Sort Order</th><th>Is Active</th></tr></thead>';
            echo '<tbody>';
            echo '<tr><td>hero</td><td>Hero Section</td><td>Welcome to Our Clinic</td><td>World-class care for your family</td><td>This section introduces the clinic with a hero message.</td><td>Book Now</td><td>/book</td><td>1</td><td>1</td></tr>';
            echo '<tr><td>services</td><td>Services Section</td><td>Our Services</td><td>Expert care in every specialty</td><td>Describe your services clearly and concisely.</td><td>Learn More</td><td>/services</td><td>2</td><td>1</td></tr>';
            echo '</tbody></table>';
            exit;
        }

        return redirect()->route('admin.sections.index');
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
                    PortfolioSection::create([
                        'section_key' => $row[0] ?? '',
                        'label' => $row[1] ?? null,
                        'title' => $row[2] ?? null,
                        'subtitle' => $row[3] ?? null,
                        'content' => $row[4] ?? null,
                        'button_text' => $row[5] ?? null,
                        'button_link' => $row[6] ?? null,
                        'sort_order' => (int) ($row[7] ?? 0),
                        'is_active' => isset($row[8]) && in_array(strtolower(trim($row[8])), ['1', 'yes', 'true'], true),
                    ]);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = 'Row with section key "' . ($row[0] ?? 'Unknown') . '" failed: ' . $e->getMessage();
                }
            }

            fclose($handle);
        }

        if ($imported > 0) {
            $message = "Successfully imported {$imported} portfolio sections.";
            if (count($errors) > 0) {
                $message .= ' ' . count($errors) . ' rows had errors.';
            }
            return redirect()->route('admin.sections.index')->with('success', $message);
        }

        return redirect()->route('admin.sections.index')->with('error', 'No data was imported. Please check your file format.');
    }
}
