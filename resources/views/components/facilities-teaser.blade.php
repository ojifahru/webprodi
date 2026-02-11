@props(['facilities'])

<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @forelse ($facilities as $facility)
        @php
            $imagePath = $facility->image_path ?? null;
            $imageUrl = null;
            $link = \Illuminate\Support\Facades\Route::has('facilities.show')
                ? route('facilities.show', $facility)
                : '#';

            if (filled($imagePath)) {
                if (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://', '/'])) {
                    $imageUrl = $imagePath;
                } elseif (\Illuminate\Support\Str::startsWith($imagePath, 'storage/')) {
                    $imageUrl = asset($imagePath);
                } else {
                    $imageUrl = asset('storage/' . $imagePath);
                }
            }
        @endphp

        <article
            class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-50">
            @if ($imageUrl)
                <a href="{{ $link }}" class="block">
                    <img src="{{ $imageUrl }}" alt="{{ $facility->name }}" class="h-44 w-full object-cover" />
                </a>
            @endif

            <div class="p-5">
                <h3 class="text-base font-semibold text-slate-900">
                    <a href="{{ $link }}" class="hover:text-primary-600">{{ $facility->name }}</a>
                </h3>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">
                    {{ \Illuminate\Support\Str::limit((string) $facility->description, 140) ?: 'Deskripsi fasilitas belum tersedia.' }}
                </p>

                <div class="mt-4">
                    <a href="{{ $link }}"
                        class="inline-flex items-center rounded-lg bg-primary-600 px-3 py-1.5 text-sm font-semibold text-white ring-1 ring-primary-600/20 transition hover:bg-primary-500">
                        <span>Lihat detail</span>
                        <x-public.icon name="arrow-right" class="ml-2 h-4 w-4" />
                    </a>
                </div>
            </div>
        </article>
    @empty
        <article
            class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-sm text-slate-600 sm:col-span-2 lg:col-span-3">
            Data fasilitas program studi belum tersedia.
        </article>
    @endforelse
</div>
