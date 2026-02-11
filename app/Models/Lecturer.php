<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
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
