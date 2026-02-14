<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class News extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('news')
            ->setDescriptionForEvent(fn (string $eventName) => "News has been {$eventName}");
    }

    protected $fillable = [
        'study_program_id',
        'title',
        'slug',
        'content',
        'category_id',
        'status',
        'published_at',
        'author_id',
        'featured_image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'news_tags',
            'news_id',
            'tag_id'
        )->withTimestamps();
    }

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class, 'study_program_id');
    }
}
