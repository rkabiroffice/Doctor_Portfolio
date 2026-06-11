<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            if (! Schema::hasColumn('reports', 'patient_id')) {
                $table->foreignId('patient_id')
                    ->nullable()
                    ->after('prescription_id')
                    ->constrained('patients')
                    ->nullOnDelete();
                $table->index('patient_id');
            }
        });

        $reports = DB::table('reports')->get();

        foreach ($reports as $report) {
            $patientId = null;

            if ($report->appointment_id) {
                $patientId = DB::table('appointments')
                    ->where('id', $report->appointment_id)
                    ->value('patient_id');
            }

            if (! $patientId && $report->prescription_id) {
                $appointmentId = DB::table('prescriptions')
                    ->where('id', $report->prescription_id)
                    ->value('appointment_id');

                if ($appointmentId) {
                    $patientId = DB::table('appointments')
                        ->where('id', $appointmentId)
                        ->value('patient_id');
                }
            }

            if ($patientId) {
                DB::table('reports')
                    ->where('id', $report->id)
                    ->update(['patient_id' => $patientId]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            if (Schema::hasColumn('reports', 'patient_id')) {
                $table->dropForeign(['patient_id']);
                $table->dropColumn('patient_id');
            }
        });
    }
};
