<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Biography;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BiographyController extends Controller
{
    public function index(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $search = $request->string('search');

        $biographies = Biography::when($search, fn ($query) => $query->where('title', 'like', '%'.$search.'%'))
            ->orderBy('sort_order')
            ->paginate(10)
            ->withQueryString();

        return view('admin.biography.index', compact('biographies', 'search'));
    }

    public function create()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.biography.create');
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
            'video_file' => ['nullable', 'mimes:mp4,webm,ogg,mov,avi', 'max:102400'],
            'youtube_url' => ['nullable', 'url'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('video_file')) {
            $validated['video_url'] = Helper::storeUploadedFile($request, 'video_file', 'uploads/biography_videos');
        }

        if (! empty($validated['youtube_url'])) {
            $validated['youtube_url'] = Helper::normalizeYoutubeUrl($validated['youtube_url']);
        }

        Biography::create($validated);

        return redirect()->route('admin.biography.index')->with('success', 'Biography created successfully.');
    }

    public function edit(Biography $biography)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.biography.edit', compact('biography'));
    }

    public function update(Request $request, Biography $biography)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:500'],
            'subtitle' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'video_file' => ['nullable', 'mimes:mp4,webm,ogg,mov,avi', 'max:102400'],
            'youtube_url' => ['nullable', 'url'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('video_file')) {
            $validated['video_url'] = Helper::storeUploadedFile($request, 'video_file', 'uploads/biography_videos');
        }

        if (! empty($validated['youtube_url'])) {
            $validated['youtube_url'] = Helper::normalizeYoutubeUrl($validated['youtube_url']);
        }

        $biography->update($validated);

        return redirect()->route('admin.biography.index')->with('success', 'Biography updated successfully.');
    }

    public function destroy(Biography $biography)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $biography->delete();

        return redirect()->route('admin.biography.index')->with('success', 'Biography deleted successfully.');
    }

    public function export($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $biographies = Biography::orderBy('sort_order')->get();

        if ($format === 'csv') {
            $filename = 'biographies_' . date('Y-m-d_His') . '.csv';
            $handle = fopen('php://output', 'w');
            
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            fputcsv($handle, ['Title', 'Subtitle', 'Content', 'Video URL', 'YouTube URL', 'Sort Order', 'Is Active']);
            
            if ($biographies->isEmpty()) {
                fputcsv($handle, ['No data available', '', '', '', '', '', '']);
            } else {
                foreach ($biographies as $bio) {
                    fputcsv($handle, [
                        $bio->title,
                        $bio->subtitle ?? '',
                        $bio->content ?? '',
                        $bio->video_url ?? '',
                        $bio->youtube_url ?? '',
                        $bio->sort_order,
                        $bio->is_active ? 'Yes' : 'No'
                    ]);
                }
            }
            
            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'biographies_' . date('Y-m-d_His') . '.xls';
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            echo '<table border="1">';
            echo '<thead><tr><th>Title</th><th>Subtitle</th><th>Content</th><th>Video URL</th><th>YouTube URL</th><th>Sort Order</th><th>Is Active</th></tr></thead>';
            echo '<tbody>';
            
            if ($biographies->isEmpty()) {
                echo '<tr><td colspan="7" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($biographies as $bio) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($bio->title) . '</td>';
                    echo '<td>' . htmlspecialchars($bio->subtitle ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($bio->content ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($bio->video_url ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($bio->youtube_url ?? '') . '</td>';
                    echo '<td>' . $bio->sort_order . '</td>';
                    echo '<td>' . ($bio->is_active ? 'Yes' : 'No') . '</td>';
                    echo '</tr>';
                }
            }
            
            echo '</tbody></table>';
            exit;
        }

        if ($format === 'pdf') {
            $html = '<html><head><style>body{font-family:Arial,sans-serif;font-size:12px;}table{width:100%;border-collapse:collapse;margin-top:20px;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f4f4f4;font-weight:bold;}h1{text-align:center;color:#333;}</style></head><body>';
            $html .= '<h1>Biographies Report</h1>';
            $html .= '<p>Generated on: ' . date('d M Y H:i:s') . '</p>';
            $html .= '<table><thead><tr><th>Title</th><th>Subtitle</th><th>Content</th><th>Sort Order</th><th>Active</th></tr></thead><tbody>';
            
            if ($biographies->isEmpty()) {
                $html .= '<tr><td colspan="5" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($biographies as $bio) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($bio->title) . '</td>';
                    $html .= '<td>' . htmlspecialchars($bio->subtitle ?? 'N/A') . '</td>';
                    $html .= '<td>' . htmlspecialchars(substr($bio->content ?? 'N/A', 0, 100)) . '</td>';
                    $html .= '<td>' . $bio->sort_order . '</td>';
                    $html .= '<td>' . ($bio->is_active ? 'Yes' : 'No') . '</td>';
                    $html .= '</tr>';
                }
            }
            
            $html .= '</tbody></table></body></html>';
            
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="biographies_' . date('Y-m-d_His') . '.pdf"');
            
            echo $html;
            exit;
        }

        return redirect()->route('admin.biography.index');
    }

    public function downloadSample($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($format === 'csv') {
            $filename = 'biographies_sample_template.csv';
            $handle = fopen('php://output', 'w');
            
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            fputcsv($handle, ['Title', 'Subtitle', 'Content', 'Video URL', 'YouTube URL', 'Sort Order', 'Is Active']);
            fputcsv($handle, ['Dr. John Smith', 'MD, Cardiology', 'Experienced cardiologist with 15 years...', 'https://example.com/video.mp4', 'https://youtube.com/watch?v=123', '1', '1']);
            fputcsv($handle, ['Dr. Jane Doe', 'MD, Pediatrics', 'Specialist in child healthcare...', '', 'https://youtube.com/watch?v=456', '2', '1']);
            
            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'biographies_sample_template.xls';
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            echo '<table border="1">';
            echo '<thead><tr><th>Title</th><th>Subtitle</th><th>Content</th><th>Video URL</th><th>YouTube URL</th><th>Sort Order</th><th>Is Active</th></tr></thead>';
            echo '<tbody>';
            echo '<tr><td>Dr. John Smith</td><td>MD, Cardiology</td><td>Experienced cardiologist with 15 years...</td><td>https://example.com/video.mp4</td><td>https://youtube.com/watch?v=123</td><td>1</td><td>1</td></tr>';
            echo '<tr><td>Dr. Jane Doe</td><td>MD, Pediatrics</td><td>Specialist in child healthcare...</td><td></td><td>https://youtube.com/watch?v=456</td><td>2</td><td>1</td></tr>';
            echo '</tbody></table>';
            exit;
        }

        return redirect()->route('admin.biography.index');
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
                    Biography::create([
                        'title' => $row[0] ?? '',
                        'subtitle' => $row[1] ?? null,
                        'content' => $row[2] ?? null,
                        'video_url' => $row[3] ?? null,
                        'youtube_url' => $row[4] ?? null,
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
            $message = "Successfully imported {$imported} biographies.";
            if (count($errors) > 0) {
                $message .= ' ' . count($errors) . ' rows had errors.';
            }
            return redirect()->route('admin.biography.index')->with('success', $message);
        }

        return redirect()->route('admin.biography.index')->with('error', 'No data was imported. Please check your file format.');
    }
}
