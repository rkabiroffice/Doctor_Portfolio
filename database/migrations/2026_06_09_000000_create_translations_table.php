<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->text('source_text');
            $table->string('source_hash', 64);
            $table->text('translated_text');
            $table->string('language', 10)->default('bn');
            $table->string('context')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['source_hash', 'language']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
