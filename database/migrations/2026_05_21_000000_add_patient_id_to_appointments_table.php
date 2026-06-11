<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('patient_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });

        $patients = DB::table('patients')->whereNotNull('appointment_id')->get();

        foreach ($patients as $patient) {
            DB::table('appointments')
                ->where('id', $patient->appointment_id)
                ->update(['patient_id' => $patient->id]);
        }
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('patient_id');
        });
    }
};
