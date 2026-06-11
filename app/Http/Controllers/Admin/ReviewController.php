<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $search = $request->string('search');

        $reviews = Review::when($search, fn ($query) => $query->where('patient_name', 'like', '%'.$search.'%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.reviews.index', compact('reviews', 'search'));
    }

    public function create()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.reviews.create');
    }

    public function store(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'patient_name' => ['required', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_text' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        Review::create($validated);

        return redirect()->route('admin.reviews.index')->with('success', 'Review created successfully.');
    }

    public function edit(Review $review)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'patient_name' => ['required', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_text' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        $review->update($validated);

        return redirect()->route('admin.reviews.index')->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully.');
    }

    public function export($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $reviews = Review::latest()->get();

        if ($format === 'csv') {
            $filename = 'reviews_' . date('Y-m-d_His') . '.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Patient Name', 'Designation', 'Rating', 'Review Text', 'Is Published']);

            if ($reviews->isEmpty()) {
                fputcsv($handle, ['No data available', '', '', '', '']);
            } else {
                foreach ($reviews as $review) {
                    fputcsv($handle, [
                        $review->patient_name,
                        $review->designation ?? '',
                        $review->rating,
                        $review->review_text,
                        $review->is_published ? 'Yes' : 'No',
                    ]);
                }
            }

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'reviews_' . date('Y-m-d_His') . '.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Patient Name</th><th>Designation</th><th>Rating</th><th>Review Text</th><th>Is Published</th></tr></thead>';
            echo '<tbody>';

            if ($reviews->isEmpty()) {
                echo '<tr><td colspan="5" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($reviews as $review) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($review->patient_name) . '</td>';
                    echo '<td>' . htmlspecialchars($review->designation ?? '') . '</td>';
                    echo '<td>' . $review->rating . '</td>';
                    echo '<td>' . htmlspecialchars($review->review_text) . '</td>';
                    echo '<td>' . ($review->is_published ? 'Yes' : 'No') . '</td>';
                    echo '</tr>';
                }
            }

            echo '</tbody></table>';
            exit;
        }

        if ($format === 'pdf') {
            $html = '<html><head><style>body{font-family:Arial,sans-serif;font-size:12px;}table{width:100%;border-collapse:collapse;margin-top:20px;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f4f4f4;font-weight:bold;}h1{text-align:center;color:#333;}</style></head><body>';
            $html .= '<h1>Reviews Report</h1>';
            $html .= '<p>Generated on: ' . date('d M Y H:i:s') . '</p>';
            $html .= '<table><thead><tr><th>Patient Name</th><th>Designation</th><th>Rating</th><th>Review Text</th><th>Is Published</th></tr></thead><tbody>';

            if ($reviews->isEmpty()) {
                $html .= '<tr><td colspan="5" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($reviews as $review) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($review->patient_name) . '</td>';
                    $html .= '<td>' . htmlspecialchars($review->designation ?? 'N/A') . '</td>';
                    $html .= '<td>' . $review->rating . '</td>';
                    $html .= '<td>' . htmlspecialchars($review->review_text) . '</td>';
                    $html .= '<td>' . ($review->is_published ? 'Yes' : 'No') . '</td>';
                    $html .= '</tr>';
                }
            }

            $html .= '</tbody></table></body></html>';

            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="reviews_' . date('Y-m-d_His') . '.pdf"');

            echo $html;
            exit;
        }

        return redirect()->route('admin.reviews.index');
    }

    public function downloadSample($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($format === 'csv') {
            $filename = 'reviews_sample_template.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Patient Name', 'Designation', 'Rating', 'Review Text', 'Is Published']);
            fputcsv($handle, ['John Doe', 'Patient', '5', 'Excellent care and service.', '1']);
            fputcsv($handle, ['Jane Smith', 'Patient', '4', 'The staff was very supportive and attentive.', '1']);

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'reviews_sample_template.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Patient Name</th><th>Designation</th><th>Rating</th><th>Review Text</th><th>Is Published</th></tr></thead>';
            echo '<tbody>';
            echo '<tr><td>John Doe</td><td>Patient</td><td>5</td><td>Excellent care and service.</td><td>1</td></tr>';
            echo '<tr><td>Jane Smith</td><td>Patient</td><td>4</td><td>The staff was very supportive and attentive.</td><td>1</td></tr>';
            echo '</tbody></table>';
            exit;
        }

        return redirect()->route('admin.reviews.index');
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
                    Review::create([
                        'patient_name' => $row[0] ?? '',
                        'designation' => $row[1] ?? null,
                        'rating' => (int) ($row[2] ?? 0),
                        'review_text' => $row[3] ?? null,
                        'is_published' => isset($row[4]) && in_array(strtolower(trim($row[4])), ['1', 'yes', 'true'], true),
                    ]);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = 'Row with name "' . ($row[0] ?? 'Unknown') . '" failed: ' . $e->getMessage();
                }
            }

            fclose($handle);
        }

        if ($imported > 0) {
            $message = "Successfully imported {$imported} reviews.";
            if (count($errors) > 0) {
                $message .= ' ' . count($errors) . ' rows had errors.';
            }
            return redirect()->route('admin.reviews.index')->with('success', $message);
        }

        return redirect()->route('admin.reviews.index')->with('error', 'No data was imported. Please check your file format.');
    }
}
