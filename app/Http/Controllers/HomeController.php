<?php

namespace App\Http\Controllers;

use App\Models\StudyProgram;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        /** @var StudyProgram $tenant */
        $tenant = app('currentTenant');

        $latestNews = $tenant->news()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->limit(6)
            ->get();

        $featuredFacilities = $tenant->facilities()
            ->orderByDesc('is_featured')
            ->latest()
            ->limit(6)
            ->get();

        $featuredLecturers = $tenant->lecturers()
            ->orderByPivot('is_primary', 'desc')
            ->orderBy('name')
            ->limit(6)
            ->get();

        return view('home', [
            'tenant' => $tenant,
            'latestNews' => $latestNews,
            'featuredFacilities' => $featuredFacilities,
            'featuredLecturers' => $featuredLecturers,
        ]);
    }
}
