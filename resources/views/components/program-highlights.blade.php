@props([
    'tenant',
])

@php
    $rawObjectives = $tenant->objectives ?? '';
    $objectiveItems = preg_split('/\r\n|\r|\n|;/', (string) $rawObjectives);
    $highlights = collect($objectiveItems)
        ->map(fn (string $item): string => trim($item))
        ->filter()
        ->take(6);
@endphp

@if ($highlights->isNotEmpty())
    <ul class="grid gap-3 sm:grid-cols-2">
        @foreach ($highlights as $highlight)
            <li class="flex items-start gap-3 rounded-xl border border-slate-200 bg-white p-4 text-sm text-slate-700 shadow-sm">
                <span class="mt-0.5 inline-block h-2.5 w-2.5 shrink-0 rounded-full bg-sky-600"></span>
                <span>{{ $highlight }}</span>
            </li>
        @endforeach
    </ul>
@else
    <article class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-sm text-slate-600">
        Highlight keunggulan program studi belum ditambahkan.
    </article>
@endif
