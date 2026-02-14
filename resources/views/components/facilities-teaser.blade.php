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
            class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-0.5 hover:bg-slate-50 hover:shadow-md">
            @if ($imageUrl)
                <a href="{{ $link }}" class="block">
                    <img src="{{ $imageUrl }}" alt="{{ $facility->name }}" class="h-44 w-full object-cover" />
                </a>
            @endif

            <div class="p-6">
                <h3 class="text-lg font-semibold tracking-tight text-slate-900">
                    <a href="{{ $link }}" class="hover:text-primary-600">{{ $facility->name }}</a>
                </h3>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">
                    @php
                        $description = \Illuminate\Support\Str::limit((string) $facility->description, 140);
                    @endphp

                    @if (filled($description))
                        {{ $description }}
                    @else
                        <span class="italic text-slate-500">Deskripsi fasilitas belum tersedia.</span>
                    @endif
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
            class="rounded-2xl border border-dashed border-slate-200 bg-white p-8 text-sm text-slate-600 ring-1 ring-slate-200 sm:col-span-2 lg:col-span-3">
            <p class="font-medium text-slate-900">Data fasilitas belum tersedia.</p>
            <p class="mt-1 italic text-slate-500">Silakan cek kembali nanti.</p>
        </article>
    @endforelse
</div>
