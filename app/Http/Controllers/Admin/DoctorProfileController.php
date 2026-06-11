<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\DoctorProfile;
use Illuminate\Http\Request;

class DoctorProfileController extends Controller
{
    public function edit()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $profile = DoctorProfile::first();

        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'specialty' => ['required', 'string', 'max:255'],
            'experience_years' => ['required', 'integer', 'min:0'],
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['required', 'string', 'max:500'],
            'bio' => ['required', 'string'],
            'photo_url' => ['required', 'url'],
            'photo_file' => ['nullable', 'image', 'max:5120'],
            'youtube_url' => ['nullable', 'url'],
            'video_file' => ['nullable', 'mimes:mp4,webm,ogg,mov,avi', 'max:102400'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['required', 'string', 'max:50'],
            'location_text' => ['required', 'string', 'max:255'],
            'cta_text' => ['required', 'string', 'max:100'],
        ]);

        if ($request->hasFile('photo_file')) {
            $validated['photo_url'] = Helper::storeUploadedImage($request, 'photo_file', 'uploads/profile');
        }

        if ($request->hasFile('video_file')) {
            $validated['video_url'] = Helper::storeUploadedFile($request, 'video_file', 'uploads/profile_videos');
        }

        $profile = DoctorProfile::first();
        $profile->update($validated);

        return redirect()->route('admin.profile.edit')->with('success', 'Doctor profile updated successfully.');
    }

    public function export($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $profiles = DoctorProfile::orderBy('name')->get();

        if ($format === 'csv') {
            $filename = 'doctor_profiles_' . date('Y-m-d_His') . '.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Name', 'Specialty', 'Experience Years', 'Hero Title', 'Hero Subtitle', 'Bio', 'Photo URL', 'YouTube URL', 'Video URL', 'Contact Email', 'Contact Phone', 'Location Text', 'CTA Text', 'Logo Text', 'Logo Subtitle']);

            if ($profiles->isEmpty()) {
                fputcsv($handle, ['No data available', '', '', '', '', '', '', '', '', '', '', '', '', '', '']);
            } else {
                foreach ($profiles as $profile) {
                    fputcsv($handle, [
                        $profile->name,
                        $profile->specialty,
                        $profile->experience_years,
                        $profile->hero_title,
                        $profile->hero_subtitle,
                        $profile->bio,
                        $profile->photo_url,
                        $profile->youtube_url ?? '',
                        $profile->video_url ?? '',
                        $profile->contact_email,
                        $profile->contact_phone,
                        $profile->location_text,
                        $profile->cta_text,
                        $profile->logo_text ?? '',
                        $profile->logo_subtitle ?? '',
                    ]);
                }
            }

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'doctor_profiles_' . date('Y-m-d_His') . '.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Name</th><th>Specialty</th><th>Experience Years</th><th>Hero Title</th><th>Hero Subtitle</th><th>Bio</th><th>Photo URL</th><th>YouTube URL</th><th>Video URL</th><th>Contact Email</th><th>Contact Phone</th><th>Location Text</th><th>CTA Text</th><th>Logo Text</th><th>Logo Subtitle</th></tr></thead>';
            echo '<tbody>';

            if ($profiles->isEmpty()) {
                echo '<tr><td colspan="15" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($profiles as $profile) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($profile->name) . '</td>';
                    echo '<td>' . htmlspecialchars($profile->specialty) . '</td>';
                    echo '<td>' . $profile->experience_years . '</td>';
                    echo '<td>' . htmlspecialchars($profile->hero_title) . '</td>';
                    echo '<td>' . htmlspecialchars($profile->hero_subtitle) . '</td>';
                    echo '<td>' . htmlspecialchars($profile->bio) . '</td>';
                    echo '<td>' . htmlspecialchars($profile->photo_url) . '</td>';
                    echo '<td>' . htmlspecialchars($profile->youtube_url ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($profile->video_url ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($profile->contact_email) . '</td>';
                    echo '<td>' . htmlspecialchars($profile->contact_phone) . '</td>';
                    echo '<td>' . htmlspecialchars($profile->location_text) . '</td>';
                    echo '<td>' . htmlspecialchars($profile->cta_text) . '</td>';
                    echo '<td>' . htmlspecialchars($profile->logo_text ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($profile->logo_subtitle ?? '') . '</td>';
                    echo '</tr>';
                }
            }

            echo '</tbody></table>';
            exit;
        }

        if ($format === 'pdf') {
            $html = '<html><head><style>body{font-family:Arial,sans-serif;font-size:12px;}table{width:100%;border-collapse:collapse;margin-top:20px;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f4f4f4;font-weight:bold;}h1{text-align:center;color:#333;}</style></head><body>';
            $html .= '<h1>Doctor Profiles Report</h1>';
            $html .= '<p>Generated on: ' . date('d M Y H:i:s') . '</p>';
            $html .= '<table><thead><tr><th>Name</th><th>Specialty</th><th>Experience</th><th>Hero Title</th><th>Contact Email</th><th>Contact Phone</th><th>Location</th></tr></thead><tbody>';

            if ($profiles->isEmpty()) {
                $html .= '<tr><td colspan="7" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($profiles as $profile) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($profile->name) . '</td>';
                    $html .= '<td>' . htmlspecialchars($profile->specialty) . '</td>';
                    $html .= '<td>' . $profile->experience_years . '</td>';
                    $html .= '<td>' . htmlspecialchars($profile->hero_title) . '</td>';
                    $html .= '<td>' . htmlspecialchars($profile->contact_email) . '</td>';
                    $html .= '<td>' . htmlspecialchars($profile->contact_phone) . '</td>';
                    $html .= '<td>' . htmlspecialchars($profile->location_text) . '</td>';
                    $html .= '</tr>';
                }
            }

            $html .= '</tbody></table></body></html>';

            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="doctor_profiles_' . date('Y-m-d_His') . '.pdf"');

            echo $html;
            exit;
        }

        return redirect()->route('admin.profile.edit');
    }

    public function downloadSample($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($format === 'csv') {
            $filename = 'doctor_profiles_sample_template.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            fputcsv($handle, ['Name', 'Specialty', 'Experience Years', 'Hero Title', 'Hero Subtitle', 'Bio', 'Photo URL', 'YouTube URL', 'Video URL', 'Contact Email', 'Contact Phone', 'Location Text', 'CTA Text', 'Logo Text', 'Logo Subtitle']);
            fputcsv($handle, ['Dr. Sarah Rahman', 'Cardiologist', '12', 'Trusted Heart Care', 'Compassionate medicine that cares for you', 'Experienced cardiologist with a focus on preventive heart health.', 'https://example.com/doctor.jpg', 'https://youtube.com/watch?v=example', 'https://example.com/video.mp4', 'sarah@example.com', '+880123456789', 'Dhaka, Bangladesh', 'Book Online', 'HeartCare', 'Leading Cardiology Clinic']);

            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'doctor_profiles_sample_template.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo '<table border="1">';
            echo '<thead><tr><th>Name</th><th>Specialty</th><th>Experience Years</th><th>Hero Title</th><th>Hero Subtitle</th><th>Bio</th><th>Photo URL</th><th>YouTube URL</th><th>Video URL</th><th>Contact Email</th><th>Contact Phone</th><th>Location Text</th><th>CTA Text</th><th>Logo Text</th><th>Logo Subtitle</th></tr></thead>';
            echo '<tbody>';
            echo '<tr><td>Dr. Sarah Rahman</td><td>Cardiologist</td><td>12</td><td>Trusted Heart Care</td><td>Compassionate medicine that cares for you</td><td>Experienced cardiologist with a focus on preventive heart health.</td><td>https://example.com/doctor.jpg</td><td>https://youtube.com/watch?v=example</td><td>https://example.com/video.mp4</td><td>sarah@example.com</td><td>+880123456789</td><td>Dhaka, Bangladesh</td><td>Book Online</td><td>HeartCare</td><td>Leading Cardiology Clinic</td></tr>';
            echo '</tbody></table>';
            exit;
        }

        return redirect()->route('admin.profile.edit');
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
                    DoctorProfile::create([
                        'name' => $row[0] ?? '',
                        'specialty' => $row[1] ?? null,
                        'experience_years' => (int) ($row[2] ?? 0),
                        'hero_title' => $row[3] ?? null,
                        'hero_subtitle' => $row[4] ?? null,
                        'bio' => $row[5] ?? null,
                        'photo_url' => $row[6] ?? null,
                        'youtube_url' => $row[7] ?? null,
                        'video_url' => $row[8] ?? null,
                        'contact_email' => $row[9] ?? null,
                        'contact_phone' => $row[10] ?? null,
                        'location_text' => $row[11] ?? null,
                        'cta_text' => $row[12] ?? null,
                        'logo_text' => $row[13] ?? null,
                        'logo_subtitle' => $row[14] ?? null,
                    ]);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = 'Row with doctor name "' . ($row[0] ?? 'Unknown') . '" failed: ' . $e->getMessage();
                }
            }

            fclose($handle);
        }

        if ($imported > 0) {
            $message = "Successfully imported {$imported} doctor profiles.";
            if (count($errors) > 0) {
                $message .= ' ' . count($errors) . ' rows had errors.';
            }
            return redirect()->route('admin.profile.edit')->with('success', $message);
        }

        return redirect()->route('admin.profile.edit')->with('error', 'No data was imported. Please check your file format.');
    }
}
