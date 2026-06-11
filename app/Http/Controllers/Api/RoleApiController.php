<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleApiController extends Controller
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

        return response()->json(Role::orderBy('name')->get());
    }

    public function store(Request $request)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        return response()->json(Role::create([
            'name' => $validated['name'],
            'permissions' => $validated['permissions'],
            'description' => $validated['description'] ?? null,
        ]), 201);
    }

    public function show(Role $role)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        return response()->json($role);
    }

    public function update(Request $request, Role $role)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        $role->update([
            'name' => $validated['name'],
            'permissions' => $validated['permissions'],
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json($role);
    }

    public function destroy(Role $role)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $role->delete();

        return response()->json(['message' => 'Role deleted successfully.']);
    }
}
