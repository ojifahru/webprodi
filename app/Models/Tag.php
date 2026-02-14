<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Tag extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('tag')
            ->setDescriptionForEvent(fn (string $eventName) => "Tag has been {$eventName}");
    }

    protected $fillable = [
        'name',
        'slug',
        'study_program_id',
    ];

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class, 'study_program_id');
    }

    public function news()
    {
        return $this->belongsToMany(
            News::class,
            'news_tags',
            'tag_id',
            'news_id'
        )->withTimestamps();
    }
}
