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
        Schema::table('categories', function (Blueprint $table) {
            // 1. drop unique lama
            $table->dropUnique('categories_name_unique');
            $table->dropUnique('categories_slug_unique');

            // 2. tambah composite unique
            $table->unique(
                ['study_program_id', 'name'],
                'categories_study_program_name_unique'
            );

            $table->unique(
                ['study_program_id', 'slug'],
                'categories_study_program_slug_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // MariaDB may be using this composite unique as the only index that
            // supports the `study_program_id` foreign key, so ensure a dedicated
            // index exists before dropping it.
            $table->index('study_program_id', 'categories_study_program_id_index');

            // 1. drop composite unique
            $table->dropUnique('categories_study_program_name_unique');
            $table->dropUnique('categories_study_program_slug_unique');

            // 2. tambah unique lama
            $table->unique('name', 'categories_name_unique');
            $table->unique('slug', 'categories_slug_unique');
        });
    }
};
