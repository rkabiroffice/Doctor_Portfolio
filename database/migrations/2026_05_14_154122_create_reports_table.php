<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('cascade');
            $table->foreignId('prescription_id')->nullable()->constrained('prescriptions')->onDelete('cascade');
            $table->string('path');
            $table->string('name');
            $table->unsignedBigInteger('size')->nullable();
            $table->string('type')->nullable();
            $table->string('disk')->default('public');
            $table->timestamps();

            $table->index(['appointment_id', 'prescription_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
