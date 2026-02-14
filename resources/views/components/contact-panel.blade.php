@props(['tenant'])

@php
    $socialLinks = collect([
        ['label' => 'Facebook', 'url' => $tenant->facebook_link],
        ['label' => 'Instagram', 'url' => $tenant->instagram_link],
        ['label' => 'Twitter', 'url' => $tenant->twitter_link],
        ['label' => 'LinkedIn', 'url' => $tenant->linkedin_link],
        ['label' => 'YouTube', 'url' => $tenant->youtube_link],
    ])
        ->filter(fn(array $item): bool => filled($item['url']))
        ->map(function (array $item): array {
            $url = (string) $item['url'];

            if (!\Illuminate\Support\Str::startsWith($url, ['http://', 'https://'])) {
                $url = 'https://' . ltrim($url, '/');
            }

            return [
                'label' => $item['label'],
                'url' => $url,
            ];
        });
@endphp

<div class="grid gap-4 lg:grid-cols-3">
    <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Email</p>
        <p class="mt-2 text-sm text-slate-700">
            @if (filled($tenant->email))
                <a href="mailto:{{ $tenant->email }}"
                    class="font-medium text-primary-600 hover:text-primary-500">{{ $tenant->email }}</a>
            @else
                <span class="italic text-slate-500">Belum tersedia</span>
            @endif
        </p>
    </article>

    <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Telepon</p>
        <p class="mt-2 text-sm text-slate-700">
            @if (filled($tenant->phone))
                {{ $tenant->phone }}
            @else
                <span class="italic text-slate-500">Belum tersedia</span>
            @endif
        </p>
    </article>

    <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Alamat</p>
        <p class="mt-2 text-sm text-slate-700">
            @if (filled($tenant->address))
                {{ $tenant->address }}
            @else
                <span class="italic text-slate-500">Belum tersedia</span>
            @endif
        </p>
    </article>
</div>

@if ($socialLinks->isNotEmpty())
    <div class="mt-6 flex flex-wrap items-center gap-2">
        @foreach ($socialLinks as $socialLink)
            <a href="{{ $socialLink['url'] }}" target="_blank" rel="noopener noreferrer"
                class="inline-flex items-center rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-700 transition hover:border-slate-400 hover:text-slate-900">
                {{ $socialLink['label'] }}
            </a>
        @endforeach
    </div>
@endif
