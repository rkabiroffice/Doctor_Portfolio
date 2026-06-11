<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\Report;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function store(Request $request, ReportService $reportService)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'appointment_id' => ['nullable', 'exists:appointments,id', 'required_without:prescription_id'],
            'prescription_id' => ['nullable', 'exists:prescriptions,id', 'required_without:appointment_id'],
            'reports' => ['required', 'array'],
            'reports.*' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:10240'],
        ]);

        $parent = isset($validated['appointment_id'])
            ? Appointment::find($validated['appointment_id'])
            : Prescription::find($validated['prescription_id']);

        if (! $parent) {
            return redirect()->back()->with('error', 'Parent record not found.');
        }

        $reportService->attachReports($request->file('reports') ?? [], $parent);

        return redirect()->back()->with('success', 'Report uploaded successfully.');
    }

    public function download(Report $report)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if (! Storage::disk($report->disk)->exists($report->path)) {
            return redirect()->back()->with('error', 'Requested report file is not available.');
        }

        return Storage::disk($report->disk)->download($report->path, $report->name);
    }

    public function preview(Report $report)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if (! Storage::disk($report->disk)->exists($report->path)) {
            return redirect()->back()->with('error', 'Requested report file is not available.');
        }

        return Storage::disk($report->disk)->response($report->path, $report->name);
    }

    public function destroy(Report $report, ReportService $reportService)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $reportService->deleteReport($report);

        return redirect()->back()->with('success', 'Report removed successfully.');
    }
}
