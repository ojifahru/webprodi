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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('study_program_id')
                ->constrained('study_programs')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('slug');
            $table->timestamps();

            $table->unique(['study_program_id', 'name'], 'tags_study_program_name_unique');
            $table->unique(['study_program_id', 'slug'], 'tags_study_program_slug_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
