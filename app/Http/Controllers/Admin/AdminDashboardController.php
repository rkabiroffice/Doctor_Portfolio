<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Blog;
use App\Models\Clinic;
use App\Models\PortfolioSection;
use App\Models\Prescription;
use App\Models\Review;
use App\Models\Role;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'appointments' => Appointment::count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'clinics' => Clinic::count(),
            'prescriptions' => Prescription::count(),
            'published_reviews' => Review::where('is_published', true)->count(),
            'sections' => PortfolioSection::count(),
            'blogs' => Blog::count(),
            'roles' => Role::count(),
        ];

        $recentAppointments = Appointment::with('clinic')->latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentAppointments'));
    }
}
