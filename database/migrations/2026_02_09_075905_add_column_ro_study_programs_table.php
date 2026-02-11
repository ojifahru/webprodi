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
        Schema::table('study_programs', function (Blueprint $table) {
            // ======================
            // Basic & Status
            // ======================
            $table->text('description')->nullable()->after('name');
            $table->boolean('is_active')->default(true)->after('description');

            // ======================
            // Academic Metadata
            // ======================
            $table->string('faculty')->nullable()->after('is_active');
            $table->string('degree_level', 20)->nullable()->after('faculty');
            $table->string('accreditation', 50)->nullable()->after('degree_level');
            $table->string('accreditation_file_path')->nullable()->after('accreditation');
            $table->year('established_year')->nullable()->after('accreditation_file_path');

            // ======================
            // Branding & Contact
            // ======================
            $table->string('logo_path')->nullable()->after('established_year');
            $table->string('favicon_path')->nullable()->after('logo_path');
            $table->string('banner_path')->nullable()->after('favicon_path');

            $table->string('email')->nullable()->after('banner_path');
            $table->string('phone', 50)->nullable()->after('email');
            $table->string('address')->nullable()->after('phone');

            // ======================
            // Vision & Mission
            // ======================
            $table->text('vision')->nullable()->after('address');
            $table->text('mission')->nullable()->after('vision');

            // ======================
            // Website / Profile Content
            // ======================
            $table->longText('about')->nullable()->after('mission');
            $table->text('objectives')->nullable()->after('about');

            // ======================
            // Social Media
            // ======================
            $table->string('facebook_link')->nullable()->after('objectives');
            $table->string('instagram_link')->nullable()->after('facebook_link');
            $table->string('twitter_link')->nullable()->after('instagram_link');
            $table->string('linkedin_link')->nullable()->after('twitter_link');
            $table->string('youtube_link')->nullable()->after('linkedin_link');

            // ======================
            // SEO Metadata
            // ======================
            $table->string('meta_title')->nullable()->after('youtube_link');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('study_programs', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'is_active',
                'faculty',
                'degree_level',
                'accreditation',
                'accreditation_file_path',
                'established_year',
                'logo_path',
                'favicon_path',
                'banner_path',
                'email',
                'phone',
                'address',
                'vision',
                'mission',
                'about',
                'objectives',
                'facebook_link',
                'instagram_link',
                'twitter_link',
                'linkedin_link',
                'youtube_link',
                'meta_title',
                'meta_description',
                'meta_keywords',
            ]);
        });
    }
};
