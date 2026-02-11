<?php

namespace App\Http\Controllers;

use App\Models\StudyProgram;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        /** @var StudyProgram $tenant */
        $tenant = app('currentTenant');

        return view('about', [
            'tenant' => $tenant,
        ]);
    }
}
