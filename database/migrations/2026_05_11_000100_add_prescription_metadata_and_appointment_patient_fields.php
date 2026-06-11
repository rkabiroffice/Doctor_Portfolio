<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('patient_age')->nullable()->after('email');
            $table->string('sex')->nullable()->after('patient_age');
        });

        Schema::table('prescriptions', function (Blueprint $table) {
            $table->text('chief_complaint')->nullable()->after('appointment_id');
            $table->text('on_examination')->nullable()->after('chief_complaint');
            $table->string('bp')->nullable()->after('on_examination');
            $table->string('pulse')->nullable()->after('bp');
            $table->string('temperature')->nullable()->after('pulse');
            $table->string('height')->nullable()->after('temperature');
            $table->string('weight')->nullable()->after('height');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['patient_age', 'sex']);
        });

        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn(['chief_complaint', 'on_examination', 'bp', 'pulse', 'temperature', 'height', 'weight']);
        });
    }
};
