@props(['newsItems'])

<div class="grid gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3">
    @forelse ($newsItems as $news)
        @php
            $excerpt = $news->excerpt ?? \Illuminate\Support\Str::limit(strip_tags((string) $news->content), 150);
            $link = \Illuminate\Support\Facades\Route::has('news.show') ? route('news.show', $news->slug) : '#';

            $imagePath = $news->featured_image ?? null;
            $imageUrl = null;

            if (filled($imagePath)) {
                if (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://', '/'])) {
                    $imageUrl = $imagePath;
                } elseif (\Illuminate\Support\Str::startsWith($imagePath, 'storage/')) {
                    $imageUrl = asset($imagePath);
                } else {
                    $imageUrl = asset('storage/' . $imagePath);
                }
            }

            $publishedAt = filled($news->published_at) ? \Illuminate\Support\Carbon::parse($news->published_at) : null;
        @endphp

        <article @class([
            'rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-0.5 hover:bg-slate-50 hover:shadow-md',
            'overflow-hidden p-0' => filled($imageUrl),
            'p-6' => blank($imageUrl),
        ])>
            @if (filled($imageUrl))
                <a href="{{ $link }}" class="block">
                    <img src="{{ $imageUrl }}" alt="{{ $news->title }}" class="h-44 w-full object-cover" />
                </a>

                <div class="p-6">
                    <header>
                        <h3 class="text-lg font-semibold tracking-tight text-slate-900">
                            <a href="{{ $link }}" class="hover:text-primary-600">{{ $news->title }}</a>
                        </h3>

                        @if ($publishedAt)
                            <time class="mt-2 block text-xs font-medium uppercase tracking-wide text-slate-500"
                                datetime="{{ $publishedAt->toDateString() }}">
                                <span class="inline-flex items-center gap-1.5">
                                    <x-public.icon name="calendar" class="h-3.5 w-3.5" />
                                    {{ $publishedAt->format('d M Y') }}
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
                </div>
            @else
                <header>
                    <h3 class="text-lg font-semibold tracking-tight text-slate-900">
                        <a href="{{ $link }}" class="hover:text-primary-600">{{ $news->title }}</a>
                    </h3>

                    @if ($publishedAt)
                        <time class="mt-2 block text-xs font-medium uppercase tracking-wide text-slate-500"
                            datetime="{{ $publishedAt->toDateString() }}">
                            <span class="inline-flex items-center gap-1.5">
                                <x-public.icon name="calendar" class="h-3.5 w-3.5" />
                                {{ $publishedAt->format('d M Y') }}
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
            @endif
        </article>
    @empty
        <article
            class="rounded-2xl border border-dashed border-slate-200 bg-white p-8 text-sm text-slate-600 ring-1 ring-slate-200 sm:col-span-2 lg:col-span-3">
            <p class="font-medium text-slate-900">Belum ada berita terbit.</p>
            <p class="mt-1 italic text-slate-500">Informasi akan diperbarui secara berkala.</p>
        </article>
    @endforelse
</div>
