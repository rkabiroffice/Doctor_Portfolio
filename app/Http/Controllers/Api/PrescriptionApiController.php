<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionApiController extends Controller
{
    protected function guard()
    {
        if (! session('admin_logged_in')) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return null;
    }

    public function index()
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        return response()->json(Prescription::with('appointment')->latest()->get());
    }

    public function store(Request $request)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'appointment_id' => ['required', 'exists:appointments,id'],
            'diagnosis' => ['required', 'string'],
            'medications' => ['required', 'string'],
            'advice' => ['nullable', 'string'],
            'follow_up_date' => ['nullable', 'date'],
        ]);

        return response()->json(Prescription::create($validated), 201);
    }

    public function show(Prescription $prescription)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        return response()->json($prescription->load('appointment'));
    }

    public function update(Request $request, Prescription $prescription)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'appointment_id' => ['required', 'exists:appointments,id'],
            'diagnosis' => ['required', 'string'],
            'medications' => ['required', 'string'],
            'advice' => ['nullable', 'string'],
            'follow_up_date' => ['nullable', 'date'],
        ]);

        $prescription->update($validated);

        return response()->json($prescription);
    }

    public function destroy(Prescription $prescription)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $prescription->delete();

        return response()->json(['message' => 'Prescription deleted successfully.']);
    }
}
