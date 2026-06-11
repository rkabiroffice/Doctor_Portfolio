<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceApiController extends Controller
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

        return response()->json(Service::orderBy('sort_order')->get());
    }

    public function store(Request $request)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['required', 'string', 'max:50'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return response()->json(Service::create($validated), 201);
    }

    public function show(Service $service)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        return response()->json($service);
    }

    public function update(Request $request, Service $service)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['required', 'string', 'max:50'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $service->update($validated);

        return response()->json($service);
    }

    public function destroy(Service $service)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $service->delete();

        return response()->json(['message' => 'Service deleted successfully.']);
    }
}
