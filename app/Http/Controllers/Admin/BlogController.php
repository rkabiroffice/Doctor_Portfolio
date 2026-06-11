<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $search = $request->string('search');

        $blogs = Blog::when($search, fn ($query) => $query->where('title', 'like', '%'.$search.'%'))
            ->orderBy('sort_order')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.blogs.index', compact('blogs', 'search'));
    }

    public function create()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'youtube_url' => ['nullable', 'url'],
            'image_url' => ['required', 'url'],
            'image_file' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image_url'] = Helper::storeUploadedImage($request, 'image_file', 'uploads/blogs');
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['youtube_url'] = Helper::normalizeYoutubeUrl($validated['youtube_url'] ?? null);

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'youtube_url' => ['nullable', 'url'],
            'image_url' => ['required', 'url'],
            'image_file' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image_url'] = Helper::storeUploadedImage($request, 'image_file', 'uploads/blogs');
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['youtube_url'] = Helper::normalizeYoutubeUrl($validated['youtube_url'] ?? null);

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully.');
    }

    public function export($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $blogs = Blog::orderBy('sort_order')->latest()->get();

        if ($format === 'csv') {
            $filename = 'blogs_' . date('Y-m-d_His') . '.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Title', 'Excerpt', 'Content', 'YouTube URL', 'Image URL', 'Sort Order', 'Is Published']);

            if ($blogs->isEmpty()) {
                fputcsv($handle, ['No data available', '', '', '', '', '', '']);
            } else {
                foreach ($blogs as $blog) {
                    fputcsv($handle, [
                        $blog->title,
                        $blog->excerpt,
                        $blog->content,
                        $blog->youtube_url ?? '',
                        $blog->image_url,
                        $blog->sort_order,
                        $blog->is_published ? 'Yes' : 'No',
                    ]);
                }
            }

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'blogs_' . date('Y-m-d_His') . '.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Title</th><th>Excerpt</th><th>Content</th><th>YouTube URL</th><th>Image URL</th><th>Sort Order</th><th>Is Published</th></tr></thead>';
            echo '<tbody>';

            if ($blogs->isEmpty()) {
                echo '<tr><td colspan="7" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($blogs as $blog) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($blog->title) . '</td>';
                    echo '<td>' . htmlspecialchars($blog->excerpt) . '</td>';
                    echo '<td>' . htmlspecialchars($blog->content) . '</td>';
                    echo '<td>' . htmlspecialchars($blog->youtube_url ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($blog->image_url) . '</td>';
                    echo '<td>' . $blog->sort_order . '</td>';
                    echo '<td>' . ($blog->is_published ? 'Yes' : 'No') . '</td>';
                    echo '</tr>';
                }
            }

            echo '</tbody></table>';
            exit;
        }

        if ($format === 'pdf') {
            $html = '<html><head><style>body{font-family:Arial,sans-serif;font-size:12px;}table{width:100%;border-collapse:collapse;margin-top:20px;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f4f4f4;font-weight:bold;}h1{text-align:center;color:#333;}</style></head><body>';
            $html .= '<h1>Blogs Report</h1>';
            $html .= '<p>Generated on: ' . date('d M Y H:i:s') . '</p>';
            $html .= '<table><thead><tr><th>Title</th><th>Excerpt</th><th>Image URL</th><th>Sort Order</th><th>Published</th></tr></thead><tbody>';

            if ($blogs->isEmpty()) {
                $html .= '<tr><td colspan="5" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($blogs as $blog) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($blog->title) . '</td>';
                    $html .= '<td>' . htmlspecialchars($blog->excerpt) . '</td>';
                    $html .= '<td>' . htmlspecialchars($blog->image_url) . '</td>';
                    $html .= '<td>' . $blog->sort_order . '</td>';
                    $html .= '<td>' . ($blog->is_published ? 'Yes' : 'No') . '</td>';
                    $html .= '</tr>';
                }
            }

            $html .= '</tbody></table></body></html>';

            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="blogs_' . date('Y-m-d_His') . '.pdf"');

            echo $html;
            exit;
        }

        return redirect()->route('admin.blogs.index');
    }

    public function downloadSample($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($format === 'csv') {
            $filename = 'blogs_sample_template.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Title', 'Excerpt', 'Content', 'YouTube URL', 'Image URL', 'Sort Order', 'Is Published']);
            fputcsv($handle, ['Healthy Living Tips', 'Short tips for a healthier lifestyle.', 'This blog covers simple daily improvements you can make to your health.', 'https://www.youtube.com/watch?v=example', 'https://example.com/blog1.jpg', '1', '1']);
            fputcsv($handle, ['Nutrition Advice', 'Balanced eating habits explained.', 'A complete nutrition guide for all ages.', '', 'https://example.com/blog2.jpg', '2', '0']);

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'blogs_sample_template.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Title</th><th>Excerpt</th><th>Content</th><th>YouTube URL</th><th>Image URL</th><th>Sort Order</th><th>Is Published</th></tr></thead>';
            echo '<tbody>';
            echo '<tr><td>Healthy Living Tips</td><td>Short tips for a healthier lifestyle.</td><td>This blog covers simple daily improvements you can make to your health.</td><td>https://www.youtube.com/watch?v=example</td><td>https://example.com/blog1.jpg</td><td>1</td><td>1</td></tr>';
            echo '<tr><td>Nutrition Advice</td><td>Balanced eating habits explained.</td><td>A complete nutrition guide for all ages.</td><td></td><td>https://example.com/blog2.jpg</td><td>2</td><td>0</td></tr>';
            echo '</tbody></table>';
            exit;
        }

        return redirect()->route('admin.blogs.index');
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
                    Blog::create([
                        'title' => $row[0] ?? '',
                        'excerpt' => $row[1] ?? null,
                        'content' => $row[2] ?? null,
                        'youtube_url' => $row[3] ?? null,
                        'image_url' => $row[4] ?? null,
                        'sort_order' => (int) ($row[5] ?? 0),
                        'is_published' => isset($row[6]) && in_array(strtolower(trim($row[6])), ['1', 'yes', 'true'], true),
                    ]);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = 'Row with title "' . ($row[0] ?? 'Unknown') . '" failed: ' . $e->getMessage();
                }
            }

            fclose($handle);
        }

        if ($imported > 0) {
            $message = "Successfully imported {$imported} blogs.";
            if (count($errors) > 0) {
                $message .= ' ' . count($errors) . ' rows had errors.';
            }
            return redirect()->route('admin.blogs.index')->with('success', $message);
        }

        return redirect()->route('admin.blogs.index')->with('error', 'No data was imported. Please check your file format.');
    }
}
