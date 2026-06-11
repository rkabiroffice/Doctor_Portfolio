<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate appointment reports if the legacy column exists.
        if (Schema::hasColumn('appointments', 'reports')) {
            $appointments = DB::table('appointments')->whereNotNull('reports')->get();
            foreach ($appointments as $appointment) {
                $reports = json_decode($appointment->reports, true);
                if (is_array($reports)) {
                    foreach ($reports as $report) {
                        DB::table('reports')->insert([
                            'appointment_id' => $appointment->id,
                            'prescription_id' => null,
                            'path' => $report['path'] ?? '',
                            'name' => $report['name'] ?? '',
                            'size' => $report['size'] ?? null,
                            'type' => $report['type'] ?? null,
                            'disk' => $report['disk'] ?? 'public',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }

        // Migrate prescription reports if the legacy column exists.
        if (Schema::hasColumn('prescriptions', 'reports')) {
            $prescriptions = DB::table('prescriptions')->whereNotNull('reports')->get();
            foreach ($prescriptions as $prescription) {
                $reports = json_decode($prescription->reports, true);
                if (is_array($reports)) {
                    foreach ($reports as $report) {
                        DB::table('reports')->insert([
                            'appointment_id' => null,
                            'prescription_id' => $prescription->id,
                            'path' => $report['path'] ?? '',
                            'name' => $report['name'] ?? '',
                            'size' => $report['size'] ?? null,
                            'type' => $report['type'] ?? null,
                            'disk' => $report['disk'] ?? 'public',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('reports')->truncate();
    }
};
