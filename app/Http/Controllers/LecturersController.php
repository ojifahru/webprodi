<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\StudyProgram;
use Illuminate\Contracts\View\View;

class LecturersController extends Controller
{
    public function show(Lecturer $lecturer): View
    {
        /** @var StudyProgram $tenant */
        $tenant = app('currentTenant');

        $isInTenant = $lecturer->studyPrograms()
            ->whereKey($tenant->id)
            ->exists();

        if (! $isInTenant) {
            abort(404);
        }

        return view('lecturers.show', [
            'tenant' => $tenant,
            'lecturer' => $lecturer,
        ]);
    }
}
