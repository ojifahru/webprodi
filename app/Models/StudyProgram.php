<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class StudyProgram extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('study_program')
            ->setDescriptionForEvent(fn (string $eventName) => "Study Program has been {$eventName}");
    }

    protected $fillable = [
        'name',
        'code',
        'domain',
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

    ];

    protected $casts = [
        'is_active' => 'boolean',
        'established_year' => 'integer',
    ];

    public function authors()
    {
        return $this->belongsToMany(User::class, 'authors_study_program', 'study_program_id', 'user_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'study_program_id');
    }

    public function tags()
    {
        return $this->hasMany(Tag::class, 'study_program_id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'study_program_id');
    }

    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class, 'lecturer_study_program')
            ->withPivot('is_primary')
            ->withTimestamps();
    }

    public function facilities()
    {
        return $this->hasMany(Facility::class, 'study_program_id');
    }
}
