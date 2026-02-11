{{-- 
Copilot: Follow UNIBA Academic Design System from .copilot-design.md
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $tenant->meta_title ?? $tenant->name }}</title>
    <meta name="description" content="{{ $tenant->meta_description ?? ($tenant->description ?? $tenant->name) }}">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('storage/' . $tenant->favicon_path) }}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-full bg-gradient-to-b from-primary-50 via-white to-white font-sans text-slate-900 antialiased">
    <div class="flex min-h-screen flex-col">
        <x-public.navbar :tenant="$tenant" />

        <main class="flex-1">
            @yield('content')
        </main>

        <x-public.footer :tenant="$tenant" />
    </div>
</body>

</html>
