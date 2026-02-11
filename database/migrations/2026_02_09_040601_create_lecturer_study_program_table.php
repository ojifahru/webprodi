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
        Schema::create('lecturer_study_program', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lecturer_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('study_program_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->boolean('is_primary')->default(false);

            $table->timestamps();

            $table->unique(['lecturer_id', 'study_program_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturer_study_program');
    }
};
