<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private array $permissionOptions = [
        'manage_profile',
        'manage_sections',
        'manage_services',
        'manage_education',
        'manage_blogs',
        'manage_clinics',
        'manage_schedules',
        'manage_reviews',
        'manage_appointments',
        'manage_prescriptions',
        'manage_roles',
        'view_profile',
        'view_appointments',
    ];

    public function index(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $search = $request->string('search');

        $roles = Role::when($search, fn ($query) => $query->where('name', 'like', '%'.$search.'%'))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.roles.index', compact('roles', 'search'));
    }

    public function create()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $permissionOptions = $this->permissionOptions;

        return view('admin.roles.create', compact('permissionOptions'));
    }

    public function store(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['required', 'string'],
        ]);

        Role::create($validated);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $permissionOptions = $this->permissionOptions;

        return view('admin.roles.edit', compact('role', 'permissionOptions'));
    }

    public function update(Request $request, Role $role)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['required', 'string'],
        ]);

        $role->update($validated);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
