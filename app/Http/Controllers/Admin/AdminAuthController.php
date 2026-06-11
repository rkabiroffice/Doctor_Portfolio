<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

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
            return back()->withErrors(['email' => 'Invalid admin credentials.'])->onlyInput('email');
        }

        session([
            'admin_logged_in' => true,
            'admin_user' => $allowed[$credentials['email']]['name'],
            'admin_email' => $credentials['email'],
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_user', 'admin_email']);

        return redirect()->route('admin.login');
    }
}
