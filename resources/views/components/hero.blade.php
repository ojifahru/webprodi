@props(['tenant'])

@php
    use Illuminate\Support\Str;

    $description = filled($tenant->description) ? Str::limit((string) $tenant->description, 180) : null;

    $bannerPath = $tenant->banner_path ?? null;
    $bannerUrl = null;

    if (filled($bannerPath)) {
        if (Str::startsWith($bannerPath, ['http://', 'https://', '/'])) {
            $bannerUrl = $bannerPath;
        } elseif (Str::startsWith($bannerPath, 'storage/')) {
            $bannerUrl = asset($bannerPath);
        } else {
            $bannerUrl = asset('storage/' . $bannerPath);
        }
    }

    $hasBanner = filled($bannerUrl);

    $eyebrowParts = array_filter([$tenant->faculty ? 'Fakultas ' . $tenant->faculty : null, $tenant->degree_level]);
@endphp

<section class="relative overflow-hidden border-b border-slate-200 bg-gradient-to-b from-primary-50 via-white to-white">

    {{-- Background Accent --}}
    <div class="absolute inset-x-0 top-0 h-48 bg-gradient-to-br from-primary-600/10 via-primary-500/10 to-transparent">
    </div>

    <div
        class="relative mx-auto grid w-full max-w-6xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-12 lg:items-center lg:px-8">

        {{-- LEFT CONTENT --}}
        <div class="lg:col-span-7">

            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-primary-600">
                {{ implode(' • ', $eyebrowParts) }}
            </p>

            <h1 class="mt-4 text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">
                {{ $tenant->name }}
            </h1>

            @if ($description)
                <p class="mt-5 max-w-2xl text-[17px] leading-7 text-slate-600">
                    {{ $description }}
                </p>
            @endif

            {{-- CTA --}}
            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a href="#contact"
                    class="inline-flex items-center rounded-lg bg-primary-600 px-6 py-3 text-sm font-semibold text-white shadow-sm ring-1 ring-primary-600/20 transition hover:bg-primary-500">
                    Hubungi Prodi
                </a>

                <a href="#latest-news"
                    class="inline-flex items-center rounded-lg bg-white px-6 py-3 text-sm font-semibold text-slate-700 ring-1 ring-slate-300 transition hover:bg-slate-50 hover:ring-slate-400 hover:text-slate-900">
                    Lihat Berita
                </a>
            </div>
            {{-- Divider --}}
            <div class="mt-4 h-px w-20 bg-slate-200"></div>

            {{-- CONTACT --}}
            <div class="mt-4 flex flex-wrap items-center gap-4 text-sm">
                @if ($tenant->email)
                    <a href="mailto:{{ $tenant->email }}"
                        class="inline-flex items-center gap-2 text-slate-500 tracking-wide hover:text-primary-600 transition">
                        <span class="h-1.5 w-1.5 rounded-full bg-primary-600"></span>
                        {{ $tenant->email }}
                    </a>
                @endif

                @if ($tenant->phone)
                    <span class="inline-flex items-center gap-2 text-slate-600">
                        <span class="h-1.5 w-1.5 rounded-full bg-primary-600"></span>
                        {{ $tenant->phone }}
                    </span>
                @endif
            </div>

        </div>

        {{-- RIGHT BANNER --}}
        <div class="lg:col-span-5">
            <figure class="overflow-hidden rounded-3xl bg-white p-3 shadow-lg ring-1 ring-slate-200">

                @if ($hasBanner)
                    <img src="{{ $bannerUrl }}" alt="{{ $tenant->name }} banner"
                        class="h-64 w-full rounded-2xl object-cover sm:h-72 lg:h-80" />
                @else
                    <div
                        class="flex h-64 w-full items-center justify-center rounded-2xl bg-gradient-to-br from-slate-200 via-slate-100 to-white sm:h-72 lg:h-80">
                        <span class="text-sm font-medium italic text-slate-500">
                            Banner belum tersedia
                        </span>
                    </div>
                @endif

            </figure>
        </div>
    </div>
</section>
