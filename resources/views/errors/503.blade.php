@php
    $pageTitle = $tenant->meta_title ?? ($tenant->name ?? 'Program Studi');
    $pageDescription =
        $tenant->meta_description ?? ($tenant->description ?? ($tenant->name ?? 'Website program studi'));
    $faviconPath = $tenant->favicon_path ?? null;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">

    @if (filled($faviconPath))
        <link rel="icon" href="{{ asset('storage/' . $faviconPath) }}" type="image/x-icon">
    @endif

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-full bg-gradient-to-b from-primary-50 via-white to-white font-sans text-slate-900 antialiased">
    <div class="flex min-h-screen flex-col">
        <main class="flex-1">
            <div class="mx-auto flex max-w-3xl flex-col gap-4 px-6 py-20">
                <div class="rounded-2xl border border-slate-200 bg-white p-8">
                    <div class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-primary-50 ring-1 ring-primary-600/15">
                        <svg viewBox="0 0 24 24" aria-hidden="true" class="h-7 w-7 text-primary-600">
                            <path fill="currentColor"
                                d="M11 2a1 1 0 0 1 1 1v1.07a8.98 8.98 0 0 1 2.73.73l.76-1.32a1 1 0 1 1 1.73 1l-.76 1.32c.78.5 1.5 1.12 2.12 1.84l1.32-.76a1 1 0 1 1 1 1.73l-1.32.76c.34.86.58 1.77.7 2.71H22a1 1 0 1 1 0 2h-1.07a8.98 8.98 0 0 1-.73 2.73l1.32.76a1 1 0 1 1-1 1.73l-1.32-.76A8.98 8.98 0 0 1 16.37 19l.76 1.32a1 1 0 1 1-1.73 1l-.76-1.32c-.86.34-1.77.58-2.71.7V22a1 1 0 1 1-2 0v-1.07a8.98 8.98 0 0 1-2.73-.73l-.76 1.32a1 1 0 1 1-1.73-1l.76-1.32A8.98 8.98 0 0 1 4.8 17.36l-1.32.76a1 1 0 1 1-1-1.73l1.32-.76A8.98 8.98 0 0 1 3.1 13H2a1 1 0 1 1 0-2h1.07a8.98 8.98 0 0 1 .73-2.73L2.48 7.5a1 1 0 1 1 1-1.73l1.32.76A8.98 8.98 0 0 1 7.63 5l-.76-1.32a1 1 0 1 1 1.73-1l.76 1.32c.86-.34 1.77-.58 2.71-.7V3a1 1 0 0 1 1-1Zm1 6a1 1 0 0 1 .99.86L13 9v3.59l2.2 2.2a1 1 0 0 1-1.32 1.5l-.1-.08-2.5-2.5A1 1 0 0 1 11 13V9a1 1 0 0 1 1-1Z" />
                        </svg>
                    </div>

                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Status</p>
                    <h1 class="mt-2 text-2xl font-semibold tracking-tight">Sedang dalam perawatan</h1>
                    <p class="mt-3 text-slate-600">
                        {{ $tenant->name ?? 'Website program studi' }} sedang tidak aktif untuk sementara waktu.
                        Silakan coba lagi nanti.
                    </p>

                    <div class="mt-6 text-sm text-slate-500">
                        @if (!empty($tenant?->email))
                            <div>Kontak: {{ $tenant->email }}</div>
                        @endif
                        @if (!empty($tenant?->phone))
                            <div>Telepon: {{ $tenant->phone }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
