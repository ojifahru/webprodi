<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\StudyProgram;
use Illuminate\Contracts\View\View;

class FacilitiesController extends Controller
{
    public function index(): View
    {
        /** @var StudyProgram $tenant */
        $tenant = app('currentTenant');

        $facilities = $tenant->facilities()
            ->latest()
            ->paginate(9);

        return view('facilities.index', [
            'tenant' => $tenant,
            'facilities' => $facilities,
        ]);
    }

    public function show(Facility $facility): View
    {
        /** @var StudyProgram $tenant */
        $tenant = app('currentTenant');

        if ($facility->study_program_id !== $tenant->id) {
            abort(404);
        }

        return view('facilities.show', [
            'tenant' => $tenant,
            'facility' => $facility,
        ]);
    }
}
