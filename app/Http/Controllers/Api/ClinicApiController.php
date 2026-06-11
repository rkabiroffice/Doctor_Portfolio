<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicApiController extends Controller
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

        return response()->json(Clinic::with('schedules')->latest()->get());
    }

    public function store(Request $request)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string', 'max:100'],
            'phones' => ['required', 'array', 'min:1'],
            'phones.*' => ['required', 'string', 'max:50'],
            'map_embed_url' => ['nullable', 'url'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return response()->json(Clinic::create($validated), 201);
    }

    public function show(Clinic $clinic)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        return response()->json($clinic->load('schedules'));
    }

    public function update(Request $request, Clinic $clinic)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string', 'max:100'],
            'phones' => ['required', 'array', 'min:1'],
            'phones.*' => ['required', 'string', 'max:50'],
            'map_embed_url' => ['nullable', 'url'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $clinic->update($validated);

        return response()->json($clinic);
    }

    public function destroy(Clinic $clinic)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $clinic->delete();

        return response()->json(['message' => 'Clinic deleted successfully.']);
    }
}
