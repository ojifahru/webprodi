@props(['tenant'])

@php
    $infoItems = [
        [
            'label' => 'Jenjang',
            'value' => $tenant->degree_level,
        ],
        [
            'label' => 'Fakultas',
            'value' => $tenant->faculty,
        ],
        [
            'label' => 'Akreditasi',
            'value' => $tenant->accreditation,
        ],
        [
            'label' => 'Tahun Berdiri',
            'value' => $tenant->established_year ? (string) $tenant->established_year : null,
        ],
    ];
@endphp

<div class="relative -mt-10 px-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-6xl">
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">

            @foreach ($infoItems as $item)
                <article
                    class="flex items-center gap-3 rounded-xl bg-white/90 p-4 backdrop-blur shadow-sm ring-1 ring-slate-200 transition hover:shadow-md">

                    {{-- Accent bar --}}
                    <span class="h-8 w-1 rounded-full bg-primary-600"></span>

                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">
                            {{ $item['label'] }}
                        </p>

                        <p class="mt-1 text-base font-semibold text-slate-900">
                            {{ $item['value'] ?: 'Belum tersedia' }}
                        </p>
                    </div>
                </article>
            @endforeach

        </div>
    </div>
</div>
