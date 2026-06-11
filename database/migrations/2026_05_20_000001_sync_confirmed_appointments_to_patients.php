<?php

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'date_of_birth')) {
                $table->dropColumn('date_of_birth');
            }

            if (! Schema::hasColumn('patients', 'patient_age')) {
                $table->string('patient_age')->nullable()->after('sex');
            }
        });

        Appointment::with('prescription')
            ->where('status', 'confirmed')
            ->chunk(100, function ($appointments) {
                foreach ($appointments as $appointment) {
                    Patient::updateOrCreate(
                        ['appointment_id' => $appointment->id],
                        [
                            'name' => $appointment->patient_name,
                            'email' => $appointment->email,
                            'phone' => $appointment->phone,
                            'sex' => $appointment->sex,
                            'patient_age' => $appointment->patient_age,
                            'clinic_id' => $appointment->clinic_id,
                            'schedule_id' => $appointment->schedule_id,
                            'appointment_id' => $appointment->id,
                            'prescription_id' => $appointment->prescription?->id,
                            'notes' => $appointment->notes,
                        ]
                    );
                }
            });
    }

    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'patient_age')) {
                $table->dropColumn('patient_age');
            }
            if (! Schema::hasColumn('patients', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('sex');
            }
        });
    }
};
