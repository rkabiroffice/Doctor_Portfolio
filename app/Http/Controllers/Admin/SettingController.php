<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Helpers\Helper;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_tagline' => ['required', 'string', 'max:500'],
            'logo_text' => ['required', 'string', 'max:255'],
            'logo_url' => ['nullable', 'url'],
            'favicon_url' => ['nullable', 'url'],
            'logo_file' => ['nullable', 'image', 'max:5120'],
            'favicon_file' => ['nullable', 'image', 'max:5120'],
            'signature_file' => ['nullable', 'image', 'max:5120'],
            'stamp_file' => ['nullable', 'image', 'max:5120'],
            'social_facebook' => ['nullable', 'url'],
            'social_facebook_pages' => ['nullable', 'array'],
            'social_facebook_pages.*' => ['nullable', 'url'],
            'social_twitter' => ['nullable', 'url'],
            'social_instagram' => ['nullable', 'url'],
            'social_linkedin' => ['nullable', 'url'],
            'social_youtube' => ['nullable', 'url'],
            'social_tiktok' => ['nullable', 'url'],
            'primary_color' => ['required', 'string', 'max:20'],
            'secondary_color' => ['nullable', 'string', 'max:20'],
            'footer_text' => ['nullable', 'string', 'max:500'],
            'top_notice' => ['nullable', 'string', 'max:500'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            // 'prescription_footer_text' => ['nullable', 'string', 'max:500'],
            'show_portfolio_sections' => ['nullable', 'in:0,1'],
        ]);

        $currentSettings = Setting::pluck('value', 'key')->all();

        $facebookPages = $validated['social_facebook_pages'] ?? null;
        if (is_null($facebookPages)) {
            $facebookPages = $currentSettings['social_facebook_pages'] ?? null;
            $facebookPages = $facebookPages ? json_decode($facebookPages, true) : [];
        }
        $facebookPages = array_values(array_filter((array) $facebookPages));

        $settings = [
            'site_name' => $validated['site_name'],
            'site_tagline' => $validated['site_tagline'] ?? ($currentSettings['site_tagline'] ?? null),
            'primary_color' => $validated['primary_color'] ?? ($currentSettings['primary_color'] ?? null),
            'secondary_color' => $validated['secondary_color'] ?? ($currentSettings['secondary_color'] ?? null),
            'footer_text' => $validated['footer_text'] ?? ($currentSettings['footer_text'] ?? null),
            'top_notice' => $validated['top_notice'] ?? ($currentSettings['top_notice'] ?? null),
            'logo_text' => $validated['logo_text'] ?? ($currentSettings['logo_text'] ?? null),
            'meta_description' => $validated['meta_description'] ?? ($currentSettings['meta_description'] ?? null),
            'meta_keywords' => $validated['meta_keywords'] ?? ($currentSettings['meta_keywords'] ?? null),
            'prescription_footer_text' => $validated['prescription_footer_text'] ?? ($currentSettings['prescription_footer_text'] ?? null),
            'social_facebook' => $validated['social_facebook'] ?? ($currentSettings['social_facebook'] ?? null),
            'social_facebook_pages' => count($facebookPages) ? json_encode($facebookPages) : null,
            'social_twitter' => $request->has('social_twitter') ? $request->social_twitter : null,
            'social_instagram' => $request->has('social_instagram') ? $request->social_instagram : null,
            'social_linkedin'  => $request->has('social_linkedin')  ? $request->social_linkedin  : null,
            'social_youtube' => $validated['social_youtube'] ?? ($currentSettings['social_youtube'] ?? null),
            'social_tiktok' => $validated['social_tiktok'] ?? ($currentSettings['social_tiktok'] ?? null),
            'show_portfolio_sections' => $validated['show_portfolio_sections'] ?? ($currentSettings['show_portfolio_sections'] ?? '1'),
        ];

        $settings['logo_url'] = $request->hasFile('logo_file')
            ? Helper::storeUploadedImage($request, 'logo_file', 'uploads/settings', $currentSettings['logo_url'] ?? null)
            : ($validated['logo_url'] ?? ($currentSettings['logo_url'] ?? null));
        $settings['favicon_url'] = $request->hasFile('favicon_file')
            ? Helper::storeUploadedImage($request, 'favicon_file', 'uploads/settings', $currentSettings['favicon_url'] ?? null)
            : ($validated['favicon_url'] ?? ($currentSettings['favicon_url'] ?? null));
        $settings['doctor_signature'] = $request->hasFile('signature_file')
            ? Helper::storeUploadedImage($request, 'signature_file', 'uploads/settings', $currentSettings['doctor_signature'] ?? null)
            : ($currentSettings['doctor_signature'] ?? null);
        $settings['doctor_stamp'] = $request->hasFile('stamp_file')
            ? Helper::storeUploadedImage($request, 'stamp_file', 'uploads/settings', $currentSettings['doctor_stamp'] ?? null)
            : ($currentSettings['doctor_stamp'] ?? null);

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
