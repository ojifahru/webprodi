@extends('public.layouts.app')

@section('content')
    <x-public.page-header eyebrow="Berita" :title="$news->title" description="Publikasi dan aktivitas terbaru dari program studi."
        :breadcrumbs="[
            [
                'label' => 'Home',
                'href' => route('home'),
            ],
            [
                'label' => 'Berita',
                'href' => route('news.index'),
            ],
            [
                'label' => $news->title,
            ],
        ]" />

    <x-section id="news-detail" title="Ringkasan" subtitle="Informasi utama dan isi berita.">
        <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:p-8">
            <header class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div class="min-w-0">
                    <h2 class="text-xl font-semibold tracking-tight text-slate-900 sm:text-2xl">
                        {{ $news->title }}
                    </h2>

                    <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-slate-600">
                        @if ($news->published_at)
                            <time datetime="{{ \Illuminate\Support\Carbon::parse($news->published_at)->toDateString() }}">
                                <span class="inline-flex items-center gap-1.5">
                                    <x-public.icon name="calendar" class="h-4 w-4" />
                                    {{ \Illuminate\Support\Carbon::parse($news->published_at)->format('d M Y') }}
                                </span>
                            </time>
                        @endif

                        @if ($news->category)
                            <span class="text-slate-400">•</span>
                            <span>{{ $news->category->name }}</span>
                        @endif

                        @if ($news->author)
                            <span class="text-slate-400">•</span>
                            <span class="inline-flex items-center gap-1.5">
                                <x-public.icon name="user" class="h-4 w-4" />
                                {{ $news->author->name }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="shrink-0">
                    <a href="{{ route('news.index') }}"
                        class="text-sm font-semibold text-primary-600 hover:text-primary-500">
                        Kembali ke daftar
                    </a>
                </div>
            </header>

            @if ($news->tags && $news->tags->isNotEmpty())
                <div class="mt-5 flex flex-wrap gap-2">
                    @foreach ($news->tags as $tag)
                        <span
                            class="rounded-full bg-primary-50 px-3 py-1 text-xs font-medium text-primary-600 ring-1 ring-primary-600/15">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            @endif

            <div class="mt-6 space-y-4 text-[15px] leading-7 text-slate-700">
                {!! nl2br(e((string) $news->content)) !!}
            </div>
        </article>
    </x-section>
@endsection
