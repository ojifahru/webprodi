@props(['lecturers'])

<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @forelse ($lecturers as $lecturer)
        @php
            $photoPath = $lecturer->photo_path ?? null;
            $photoUrl = null;
            $link = \Illuminate\Support\Facades\Route::has('lecturers.show') ? route('lecturers.show', $lecturer) : '#';

            if (filled($photoPath)) {
                if (\Illuminate\Support\Str::startsWith($photoPath, ['http://', 'https://', '/'])) {
                    $photoUrl = $photoPath;
                } elseif (\Illuminate\Support\Str::startsWith($photoPath, 'storage/')) {
                    $photoUrl = asset($photoPath);
                } else {
                    $photoUrl = asset('storage/' . $photoPath);
                }
            }
        @endphp

        <article class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-50">
            <div class="flex items-center gap-4">
                @if ($photoUrl)
                    <a href="{{ $link }}" class="shrink-0">
                        <img src="{{ $photoUrl }}" alt="{{ $lecturer->name }}"
                            class="h-14 w-14 rounded-full object-cover" />
                    </a>
                @else
                    <a href="{{ $link }}"
                        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-slate-900 text-base font-semibold text-white">
                        {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($lecturer->name, 0, 1)) }}
                    </a>
                @endif

                <div>
                    <h3 class="text-base font-semibold text-slate-900">
                        <a href="{{ $link }}" class="hover:text-primary-600">{{ $lecturer->name }}</a>
                    </h3>
                    <p class="text-xs text-slate-500">NIDN: {{ $lecturer->nidn ?: '-' }}</p>
                </div>
            </div>

            @if (filled($lecturer->bio))
                <p class="mt-3 text-sm leading-relaxed text-slate-600">
                    {{ \Illuminate\Support\Str::limit(strip_tags((string) $lecturer->bio), 130) }}
                </p>
            @endif

            <div class="mt-4">
                <a href="{{ $link }}"
                    class="inline-flex items-center rounded-lg bg-primary-600 px-3 py-1.5 text-sm font-semibold text-white ring-1 ring-primary-600/20 transition hover:bg-primary-500">
                    <span>Lihat profil</span>
                    <x-public.icon name="arrow-right" class="ml-2 h-4 w-4" />
                </a>
            </div>
        </article>
    @empty
        <article
            class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-sm text-slate-600 sm:col-span-2 lg:col-span-3">
            Data dosen belum tersedia.
        </article>
    @endforelse
</div>
