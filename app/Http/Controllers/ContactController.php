<?php

namespace App\Http\Controllers;

use App\Models\StudyProgram;
use Illuminate\Contracts\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        /** @var StudyProgram $tenant */
        $tenant = app('currentTenant');

        return view('contact', [
            'tenant' => $tenant,
        ]);
    }
}
