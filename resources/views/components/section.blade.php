@props(['title', 'id' => null, 'subtitle' => null, 'tone' => 'default'])

@php
    $tone = (string) $tone;

    $backgroundClass = match ($tone) {
        'muted' => 'bg-slate-50',
        default => 'bg-white',
    };
@endphp

<section @if ($id) id="{{ $id }}" @endif class="py-12 sm:py-14 {{ $backgroundClass }}">
    <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
        <header class="mb-6 sm:mb-8">
            <div class="mb-3 h-1 w-14 rounded-full bg-primary-600/25"></div>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900 sm:text-3xl">{{ $title }}</h2>
            @if (filled($subtitle))
                <p class="mt-2 max-w-3xl text-sm leading-relaxed text-slate-600 sm:text-base">{{ $subtitle }}</p>
            @endif
        </header>

        {{ $slot }}
    </div>
</section>
