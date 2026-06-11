<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Prescription;
use Illuminate\Http\Request;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $allowed = [
            'admin@business.com' => ['name' => 'Doctor Admin', 'password' => 'admin123'],
            'manager@business.com' => ['name' => 'Clinic Manager', 'password' => 'manager123'],
            'supervisor@business.com' => ['name' => 'Operations Supervisor', 'password' => 'supervisor123'],
        ];

        if (! isset($allowed[$credentials['email']]) || $allowed[$credentials['email']]['password'] !== $credentials['password']) {
            return response()->json(['message' => 'Invalid credentials.'], 422);
        }

        session([
            'admin_logged_in' => true,
            'admin_user' => $allowed[$credentials['email']]['name'],
            'admin_email' => $credentials['email'],
        ]);

        return response()->json([
            'message' => 'Login successful.',
            'user' => [
                'name' => $allowed[$credentials['email']]['name'],
                'email' => $credentials['email'],
            ],
        ]);
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_user', 'admin_email']);

        return response()->json(['message' => 'Logged out successfully.']);
    }

    public function dashboard()
    {
        if (! session('admin_logged_in')) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return response()->json([
            'stats' => [
                'appointments' => Appointment::count(),
                'pending_appointments' => Appointment::where('status', 'pending')->count(),
                'clinics' => Clinic::count(),
                'prescriptions' => Prescription::count(),
            ],
            'admin' => [
                'name' => session('admin_user'),
                'email' => session('admin_email'),
            ],
        ]);
    }
}
