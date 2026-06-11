<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Blog;
use App\Models\Clinic;
use App\Models\Education;
use App\Models\HeroSection;
use App\Models\Patient;
use App\Models\AboutSection;
use App\Models\Biography;
use App\Models\PortfolioSection;
use App\Models\Review;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $heroSections = HeroSection::where('is_active', true)->orderBy('sort_order')->get();
        $aboutSections = AboutSection::where('is_active', true)->orderBy('sort_order')->get();
        $biographies = Biography::where('is_active', true)->orderBy('sort_order')->get();
        $sections = PortfolioSection::where('is_active', true)->orderBy('sort_order')->get()->keyBy('section_key');
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        $education = Education::orderByDesc('year_completed')->get();
        $reviews = Review::where('is_published', true)->latest()->get();
        $blogs = Blog::where('is_published', true)->orderBy('sort_order')->latest()->get();
        $clinics = Clinic::with(['schedules' => fn ($query) => $query->orderBy('day_order')])->where('is_active', true)->get();

        return view('welcome', compact('settings', 'heroSections', 'aboutSections', 'biographies', 'sections', 'services', 'education', 'reviews', 'blogs', 'clinics'));
    }

    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => ['nullable', 'exists:patients,id'],
            'patient_name' => ['required_without:patient_id', 'string', 'max:255'],
            'phone' => ['required_without:patient_id', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'patient_age' => ['required_without:patient_id', 'string', 'max:50'],
            'sex' => ['required_without:patient_id', 'in:Male,Female,Other'],
            'clinic_id' => ['required', 'exists:clinics,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required'],
            'reason' => ['required', 'string'],
        ]);

        if (! empty($validated['patient_id'])) {
            $patient = Patient::find($validated['patient_id']);

            if ($patient) {
                $validated['patient_name'] = $patient->name;
                $validated['phone'] = $patient->phone;
                $validated['email'] = $patient->email;
                $validated['patient_age'] = $patient->patient_age;
                $validated['sex'] = $patient->sex;
            }
        }

        $validated['status'] = 'pending';

        $appointment = Appointment::create($validated);
        Patient::syncFromAppointment($appointment);

        return redirect()->route('home')->with('success', 'Your appointment request has been submitted successfully.');
    }

    public function getPatient(Patient $patient)
    {
        return response()->json([
            'id' => $patient->id,
            'name' => $patient->name,
            'phone' => $patient->phone,
            'email' => $patient->email,
            'patient_age' => $patient->patient_age,
            'sex' => $patient->sex,
        ]);
    }
}
