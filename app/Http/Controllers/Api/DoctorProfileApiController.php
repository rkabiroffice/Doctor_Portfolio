<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Clinic;
use App\Models\DoctorProfile;
use App\Models\Education;
use App\Models\PortfolioSection;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;

class DoctorProfileApiController extends Controller
{
    public function index()
    {
        $profile = DoctorProfile::first();

        return response()->json([
            'profile' => $profile,
            'sections' => PortfolioSection::where('is_active', true)->orderBy('sort_order')->get(),
            'services' => Service::where('is_active', true)->orderBy('sort_order')->get(),
            'education' => Education::orderByDesc('year_completed')->get(),
            'blogs' => Blog::where('is_published', true)->orderBy('sort_order')->latest()->get(),
            'clinics' => Clinic::with(['schedules' => fn ($query) => $query->orderBy('day_order')])->where('is_active', true)->get(),
            'reviews' => Review::where('is_published', true)->latest()->get(),
        ]);
    }

    public function show()
    {
        if (! session('admin_logged_in')) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return response()->json(DoctorProfile::first());
    }

    public function update(Request $request)
    {
        if (! session('admin_logged_in')) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'specialty' => ['required', 'string', 'max:255'],
            'experience_years' => ['required', 'integer', 'min:0'],
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['required', 'string', 'max:500'],
            'bio' => ['required', 'string'],
            'photo_url' => ['required', 'url'],
            'youtube_url' => ['nullable', 'url'],
            'video_url' => ['nullable', 'url'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['required', 'string', 'max:50'],
            'location_text' => ['required', 'string', 'max:255'],
            'cta_text' => ['required', 'string', 'max:100'],
            'logo_text' => ['nullable', 'string', 'max:100'],
            'logo_subtitle' => ['nullable', 'string', 'max:100'],
        ]);

        $profile = DoctorProfile::first();
        $profile->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'data' => $profile,
        ]);
    }
}
