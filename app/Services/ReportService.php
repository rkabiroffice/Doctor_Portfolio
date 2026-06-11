<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ReportService
{
    public function attachReports(array $files, Model $parent): void
    {
        $this->loadPatientOnParent($parent);
        $patient = $this->patientFromParent($parent);

        foreach ($files as $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $directory = $this->storageDirectory($parent, $patient);
            $path = $file->store($directory, 'public');

            $parent->reports()->create([
                'path' => $path,
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'type' => $file->getMimeType(),
                'disk' => 'public',
                'patient_id' => $patient?->id,
            ]);
        }
    }

    public function deleteReport(Report $report): void
    {
        if (Storage::disk($report->disk)->exists($report->path)) {
            Storage::disk($report->disk)->delete($report->path);
        }

        $report->delete();
    }

    protected function storageDirectory(Model $parent, ?Patient $patient): string
    {
        $base = $patient ? 'patients/' . $patient->uid : 'reports';

        if ($parent instanceof Appointment) {
            return $base . '/appointment_reports';
        }

        if ($parent instanceof Prescription) {
            return $base . '/prescription_reports';
        }

        return $base . '/reports';
    }

    protected function loadPatientOnParent(Model $parent): void
    {
        if ($parent instanceof Appointment) {
            $parent->loadMissing('patient');
        }

        if ($parent instanceof Prescription) {
            $parent->loadMissing('appointment.patient');
        }
    }

    protected function patientFromParent(Model $parent): ?Patient
    {
        if ($parent instanceof Appointment) {
            return $parent->patient;
        }

        if ($parent instanceof Prescription) {
            return $parent->appointment?->patient;
        }

        return null;
    }
}
