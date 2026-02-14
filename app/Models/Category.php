<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('category')
            ->setDescriptionForEvent(fn (string $eventName) => "Category has been {$eventName}");
    }

    protected $fillable = [
        'name',
        'study_program_id',
        'slug',
        'description',
    ];

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class, 'study_program_id');
    }
}
