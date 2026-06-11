<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('specialty');
            $table->unsignedInteger('experience_years')->default(0);
            $table->string('hero_title');
            $table->string('hero_subtitle', 500);
            $table->text('bio');
            $table->text('photo_url');
            $table->text('youtube_url')->nullable();
            $table->text('video_url')->nullable();
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->string('location_text');
            $table->string('cta_text')->default('Book Appointment');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_profiles');
    }
};
