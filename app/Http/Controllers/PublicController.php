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
        $cacheTtl = now()->addMinutes(5);

        $data = cache()->remember('homepage_data', $cacheTtl, function () {
            return [
                'settings' => Setting::pluck('value', 'key')->all(),
                'heroSections' => HeroSection::where('is_active', true)->orderBy('sort_order')->get()->toArray(),
                'aboutSections' => AboutSection::where('is_active', true)->orderBy('sort_order')->get()->toArray(),
                'biographies' => Biography::where('is_active', true)->orderBy('sort_order')->get()->toArray(),
                'sections' => PortfolioSection::where('is_active', true)->orderBy('sort_order')->get()->keyBy('section_key')->toArray(),
                'services' => Service::where('is_active', true)->orderBy('sort_order')->get()->toArray(),
                'education' => Education::orderByDesc('year_completed')->get()->toArray(),
                'reviews' => Review::where('is_published', true)->latest()->get()->toArray(),
                'blogs' => Blog::where('is_published', true)->orderBy('sort_order')->latest()->get()->toArray(),
                'clinics' => Clinic::with(['schedules' => fn ($query) => $query->orderBy('day_order')])->where('is_active', true)->get()->toArray(),
            ];
        });

        return view('welcome', $this->prepareHomepageDataForView($data));
    }

    private function prepareHomepageDataForView(array $data): array
    {
        return [
            'settings' => $data['settings'],
            'heroSections' => $this->collectionOfObjects($data['heroSections']),
            'aboutSections' => $this->collectionOfObjects($data['aboutSections']),
            'biographies' => $this->collectionOfObjects($data['biographies']),
            'sections' => $this->collectionOfObjects($data['sections']),
            'services' => $this->collectionOfObjects($data['services']),
            'education' => $this->collectionOfObjects($data['education']),
            'reviews' => $this->collectionOfObjects($data['reviews']),
            'blogs' => $this->collectionOfObjects($data['blogs']),
            'clinics' => $this->collectionOfObjects($data['clinics'], [
                'map_iframe_url' => fn ($clinic) => \App\Helpers\Helper::normalizeGoogleMapsEmbedUrl($clinic['map_embed_url'] ?? null),
            ]),
        ];
    }

    private function collectionOfObjects(array $items, array $computedAttributes = [])
    {
        return collect($items)->map(fn ($item) => $this->arrayToObjectRecursive($item, $computedAttributes));
    }

    private function arrayToObjectRecursive(array $value, array $computedAttributes = [])
    {
        if ($this->isSequentialArray($value)) {
            return collect($value)->map(fn ($item) => is_array($item) ? $this->arrayToObjectRecursive($item) : $item);
        }

        $object = (object) array_map(fn ($item) => is_array($item) ? $this->arrayToObjectRecursive($item) : $item, $value);

        foreach ($computedAttributes as $key => $computedValue) {
            $object->{$key} = is_callable($computedValue)
                ? $computedValue($value)
                : $computedValue;
        }

        return $object;
    }

    private function isSequentialArray(array $value): bool
    {
        return array_keys($value) === range(0, count($value) - 1);
    }

    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'patient_uid' => ['nullable', 'exists:patients,uid'],
            'patient_name' => ['required_without:patient_uid', 'string', 'max:255'],
            'phone' => ['required_without:patient_uid', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'patient_age' => ['required_without:patient_uid', 'string', 'max:50'],
            'sex' => ['required_without:patient_uid', 'in:Male,Female,Other'],
            'clinic_id' => ['required', 'exists:clinics,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required'],
            'reason' => ['required', 'string'],
        ]);

        if (! empty($validated['patient_uid'])) {
            $patient = Patient::where('uid', $validated['patient_uid'])->first();

            if ($patient) {
                $validated['patient_name'] = $patient->name;
                $validated['phone'] = $patient->phone;
                $validated['email'] = $patient->email;
                $validated['patient_age'] = $patient->patient_age;
                $validated['sex'] = $patient->sex;
            }
        }

        unset($validated['patient_uid']);

        $validated['status'] = 'pending';

        $appointment = Appointment::create($validated);
        Patient::syncFromAppointment($appointment);

        return redirect()->route('home')->with('success', 'Your appointment request has been submitted successfully.');
    }

    public function getPatientByUid(string $uid)
    {
        $patient = Patient::where('uid', $uid)->firstOrFail();

        return response()->json([
            'uid' => $patient->uid,
            'id' => $patient->id,
            'name' => $patient->name,
            'phone' => $patient->phone,
            'email' => $patient->email,
            'patient_age' => $patient->patient_age,
            'sex' => $patient->sex,
        ]);
    }
}
