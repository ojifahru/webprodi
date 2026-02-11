@props([
    'eyebrow' => null,
    'title',
    'description' => null,
    /** @var array<int, array{label: string, href?: string|null}> */
    'breadcrumbs' => [],
])

<section class="border-b border-slate-200 bg-gradient-to-b from-primary-50 via-white to-white">
    <div class="mx-auto w-full max-w-6xl px-4 py-12 sm:px-6 sm:py-14 lg:px-8">
        @if (!empty($breadcrumbs))
            <nav aria-label="Breadcrumb" class="mb-5">
                <ol class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs font-medium text-slate-500">
                    @foreach ($breadcrumbs as $index => $crumb)
                        @php
                            $isLast = $index === array_key_last($breadcrumbs);
                            $href = $crumb['href'] ?? null;
                        @endphp

                        <li class="inline-flex items-center gap-x-2">
                            @if ($href && !$isLast)
                                <a href="{{ $href }}" class="transition hover:text-primary-600">
                                    {{ $crumb['label'] }}
                                </a>
                            @else
                                <span class="text-slate-600">{{ $crumb['label'] }}</span>
                            @endif

                            @if (!$isLast)
                                <svg class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M7.21 14.77a.75.75 0 010-1.06L10.94 10 7.21 6.29a.75.75 0 011.06-1.06l4.25 4.25a.75.75 0 010 1.06l-4.25 4.25a.75.75 0 01-1.06 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
        @endif

        @if (filled($eyebrow))
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-primary-600">{{ $eyebrow }}</p>
        @endif

        <h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">{{ $title }}</h1>

        @if (filled($description))
            <p class="mt-4 max-w-3xl text-[15px] leading-7 text-slate-600 sm:text-base">{{ $description }}</p>
        @endif
    </div>
</section>
