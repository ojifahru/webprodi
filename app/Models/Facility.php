<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Facility extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('facility')
            ->setDescriptionForEvent(fn (string $eventName) => "Facility has been {$eventName}");
    }

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_path',
        'study_program_id',
        'is_featured',
    ];

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class, 'study_program_id');
    }
}
