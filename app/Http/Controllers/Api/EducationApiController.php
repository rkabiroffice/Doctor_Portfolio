<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationApiController extends Controller
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

        return response()->json(Education::orderByDesc('year_completed')->get());
    }

    public function store(Request $request)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'degree' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'year_completed' => ['required', 'integer', 'min:1950', 'max:2100'],
            'details' => ['nullable', 'string'],
            'type' => ['required', 'string', 'max:100'],
        ]);

        return response()->json(Education::create($validated), 201);
    }

    public function show(Education $education)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        return response()->json($education);
    }

    public function update(Request $request, Education $education)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'degree' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'year_completed' => ['required', 'integer', 'min:1950', 'max:2100'],
            'details' => ['nullable', 'string'],
            'type' => ['required', 'string', 'max:100'],
        ]);

        $education->update($validated);

        return response()->json($education);
    }

    public function destroy(Education $education)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $education->delete();

        return response()->json(['message' => 'Education deleted successfully.']);
    }
}
