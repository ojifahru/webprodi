<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Lecturer extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('lecturer')
            ->setDescriptionForEvent(fn (string $eventName) => "Lecturer has been {$eventName}");
    }

    protected $fillable = [
        'name',
        'nidn',
        'email',
        'phone',
        'bio',
        'photo_path',
    ];

    public function studyPrograms()
    {
        return $this->belongsToMany(StudyProgram::class, 'lecturer_study_program')
            ->withPivot('is_primary')
            ->withTimestamps();
    }
}
