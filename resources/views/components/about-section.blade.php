@props(['tenant'])

@php
    $missionItems = filled($tenant->mission)
        ? array_values(
            array_filter(
                array_map(
                    static fn(string $line): string => trim($line),
                    preg_split('/\r\n|\r|\n/', (string) $tenant->mission) ?: [],
                ),
                static fn(string $line): bool => $line !== '',
            ),
        )
        : [];

    if (filled($tenant->mission) && count($missionItems) === 0) {
        $missionItems = [trim((string) $tenant->mission)];
    }
@endphp

<div class="rounded-3xl bg-white/90 p-8 shadow-sm ring-1 ring-slate-200 backdrop-blur">
    <div class="space-y-3">
        <h3 class="text-base font-semibold text-slate-900">Profil Singkat</h3>

        <p class="max-w-none text-[15px] leading-8 text-slate-700">
            {{ $tenant->about ?? ($tenant->description ?? 'Profil program studi akan segera diperbarui.') }}
        </p>
    </div>

    @if (filled($tenant->vision) || filled($tenant->mission))
        <div class="mt-10 grid gap-6 md:grid-cols-2">
            @if (filled($tenant->vision))
                <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <h3 class="flex items-center gap-3 text-base font-semibold text-slate-900">
                        <span class="h-2.5 w-2.5 rounded-full bg-accent-500"></span>
                        Visi
                    </h3>

                    <p class="mt-3 text-[15px] leading-7 text-slate-600">
                        {{ $tenant->vision }}
                    </p>
                </article>
            @endif

            @if (filled($tenant->mission))
                <article class="rounded-2xl bg-slate-50 p-6 shadow-sm ring-1 ring-slate-200">
                    <h3 class="flex items-center gap-3 text-base font-semibold text-slate-900">
                        <span class="h-2.5 w-2.5 rounded-full bg-secondary-400"></span>
                        Misi
                    </h3>

                    <ol
                        class="mt-3 space-y-2 pl-5 text-[15px] leading-7 text-slate-600 list-decimal marker:font-semibold marker:text-slate-500">
                        @foreach ($missionItems as $missionItem)
                            <li>{{ $missionItem }}</li>
                        @endforeach
                    </ol>
                </article>
            @endif
        </div>
    @endif
</div>
