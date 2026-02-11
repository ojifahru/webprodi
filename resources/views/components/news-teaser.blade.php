@props(['newsItems'])

<div class="grid gap-4 sm:gap-5">
    @forelse ($newsItems as $news)
        @php
            $excerpt = $news->excerpt ?? \Illuminate\Support\Str::limit(strip_tags((string) $news->content), 150);
            $link = \Illuminate\Support\Facades\Route::has('news.show') ? route('news.show', $news->slug) : '#';
        @endphp

        <article
            class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-0.5 hover:bg-slate-50 hover:shadow-md">
            <header class="flex items-center justify-between gap-3">
                <h3 class="text-lg font-semibold text-slate-900">
                    <a href="{{ $link }}" class="hover:text-primary-600">{{ $news->title }}</a>
                </h3>

                @if ($news->published_at)
                    <time class="shrink-0 text-xs font-medium uppercase tracking-wide text-slate-500"
                        datetime="{{ \Illuminate\Support\Carbon::parse($news->published_at)->toDateString() }}">
                        <span class="inline-flex items-center gap-1.5">
                            <x-public.icon name="calendar" class="h-3.5 w-3.5" />
                            {{ \Illuminate\Support\Carbon::parse($news->published_at)->format('d M Y') }}
                        </span>
                    </time>
                @endif
            </header>

            <p class="mt-3 text-sm leading-relaxed text-slate-600 sm:text-base">
                {{ $excerpt }}
            </p>

            <div class="mt-4">
                <a href="{{ $link }}"
                    class="inline-flex items-center rounded-lg bg-primary-600 px-3 py-1.5 text-sm font-semibold text-white ring-1 ring-primary-600/20 transition hover:bg-primary-500">
                    <span>Baca berita</span>
                    <x-public.icon name="arrow-right" class="ml-2 h-4 w-4" />
                </a>
            </div>
        </article>
    @empty
        <article class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-sm text-slate-600">
            Belum ada berita terbit untuk program studi ini.
        </article>
    @endforelse
</div>
