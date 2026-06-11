<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReportUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_appointment_report_upload_creates_report_and_redirects_back()
    {
        Storage::fake('public');

        $patient = Patient::create([
            'name' => 'Test Patient',
            'email' => 'patient@example.com',
            'phone' => '0123456789',
            'sex' => 'male',
            'patient_age' => 30,
        ]);

        $appointment = Appointment::factory()->create([
            'patient_id' => $patient->id,
            'patient_name' => $patient->name,
            'phone' => $patient->phone,
            'email' => $patient->email,
            'patient_age' => $patient->patient_age,
            'sex' => $patient->sex,
        ]);

        $this->withSession(['admin_logged_in' => true])
            ->post(route('admin.reports.store'), [
                'appointment_id' => $appointment->id,
                'reports' => [UploadedFile::fake()->create('report.pdf', 100, 'application/pdf')],
            ])
            ->assertRedirect()
            ->assertSessionHas('success', 'Report uploaded successfully.');

        $this->assertDatabaseHas('reports', [
            'appointment_id' => $appointment->id,
            'patient_id' => $patient->id,
        ]);
    }

    public function test_prescription_create_redirects_to_show_and_attaches_reports()
    {
        Storage::fake('public');

        $patient = Patient::create([
            'name' => 'Test Patient',
            'email' => 'patient2@example.com',
            'phone' => '0987654321',
            'sex' => 'female',
            'patient_age' => 25,
        ]);

        $appointment = Appointment::factory()->create([
            'patient_id' => $patient->id,
            'patient_name' => $patient->name,
            'phone' => $patient->phone,
            'email' => $patient->email,
            'patient_age' => $patient->patient_age,
            'sex' => $patient->sex,
        ]);

        $medicine = Medicine::factory()->create();

        $response = $this->withSession(['admin_logged_in' => true])
            ->post(route('admin.prescriptions.store'), [
                'appointment_id' => $appointment->id,
                'diagnosis' => 'Test diagnosis',
                'medicines' => [
                    [
                        'medicine_id' => $medicine->id,
                        'morning_dose' => '1 pill',
                        'afternoon_dose' => '1 pill',
                        'night_dose' => '1 pill',
                        'duration' => '5 days',
                        'instruction' => 'After food',
                    ],
                ],
                'reports' => [UploadedFile::fake()->create('prescription.pdf', 80, 'application/pdf')],
            ]);

        $prescription = Prescription::latest()->first();

        $response->assertRedirect(route('admin.prescriptions.show', $prescription));
        $this->assertDatabaseHas('reports', [
            'prescription_id' => $prescription->id,
            'patient_id' => $patient->id,
        ]);
    }

    public function test_prescription_update_redirects_to_show_and_attaches_reports()
    {
        Storage::fake('public');

        $patient = Patient::create([
            'name' => 'Test Patient',
            'email' => 'patient3@example.com',
            'phone' => '0112233445',
            'sex' => 'female',
            'patient_age' => 28,
        ]);

        $appointment = Appointment::factory()->create([
            'patient_id' => $patient->id,
            'patient_name' => $patient->name,
            'phone' => $patient->phone,
            'email' => $patient->email,
            'patient_age' => $patient->patient_age,
            'sex' => $patient->sex,
        ]);

        $prescription = Prescription::factory()->create([
            'appointment_id' => $appointment->id,
            'diagnosis' => 'Initial diagnosis',
        ]);

        $medicine = Medicine::factory()->create();

        $response = $this->withSession(['admin_logged_in' => true])
            ->put(route('admin.prescriptions.update', $prescription), [
                'appointment_id' => $appointment->id,
                'diagnosis' => 'Updated diagnosis',
                'medicines' => [
                    [
                        'medicine_id' => $medicine->id,
                        'morning_dose' => '2 pills',
                        'afternoon_dose' => '1 pill',
                        'night_dose' => '1 pill',
                        'duration' => '7 days',
                        'instruction' => 'With water',
                    ],
                ],
                'reports' => [UploadedFile::fake()->create('updated-report.pdf', 90, 'application/pdf')],
            ]);

        $response->assertRedirect(route('admin.prescriptions.show', $prescription));
        $this->assertDatabaseHas('reports', [
            'prescription_id' => $prescription->id,
            'patient_id' => $patient->id,
        ]);
    }
}
