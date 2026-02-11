<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\StudyProgram;
use Illuminate\Contracts\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        /** @var StudyProgram $tenant */
        $tenant = app('currentTenant');

        $newsItems = $tenant->news()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->paginate(10);

        return view('news.index', [
            'tenant' => $tenant,
            'newsItems' => $newsItems,
        ]);
    }

    public function show(News $news): View
    {
        /** @var StudyProgram $tenant */
        $tenant = app('currentTenant');

        if ($news->study_program_id !== $tenant->id) {
            abort(404);
        }

        if ($news->status !== 'published' || blank($news->published_at)) {
            abort(404);
        }

        $news->loadMissing(['category', 'author', 'tags']);

        return view('news.show', [
            'tenant' => $tenant,
            'news' => $news,
        ]);
    }
}
