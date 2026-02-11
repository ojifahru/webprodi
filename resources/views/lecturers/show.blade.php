@extends('public.layouts.app')

@section('content')
    <x-public.page-header eyebrow="Dosen" :title="$lecturer->name" description="Profil dosen program studi." :breadcrumbs="[
        [
            'label' => 'Home',
            'href' => route('home'),
        ],
        [
            'label' => 'Dosen',
        ],
        [
            'label' => $lecturer->name,
        ],
    ]" />

    @php
        $photoPath = $lecturer->photo_path ?? null;
        $photoUrl = null;

        if (filled($photoPath)) {
            if (\Illuminate\Support\Str::startsWith($photoPath, ['http://', 'https://', '/'])) {
                $photoUrl = $photoPath;
            } elseif (\Illuminate\Support\Str::startsWith($photoPath, 'storage/')) {
                $photoUrl = asset($photoPath);
            } else {
                $photoUrl = asset('storage/' . $photoPath);
            }
        }

        $initial = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($lecturer->name, 0, 1));
    @endphp

    <x-section id="lecturer-detail" title="Profil" subtitle="Informasi dosen yang terdaftar pada program studi.">
        <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:p-8">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-start">
                <div class="shrink-0">
                    @if ($photoUrl)
                        <img src="{{ $photoUrl }}" alt="{{ $lecturer->name }}"
                            class="h-24 w-24 rounded-2xl object-cover ring-1 ring-slate-200" />
                    @else
                        <div
                            class="flex h-24 w-24 items-center justify-center rounded-2xl bg-slate-900 text-2xl font-semibold text-white">
                            {{ $initial }}
                        </div>
                    @endif
                </div>

                <div class="min-w-0 flex-1">
                    <h2 class="text-xl font-semibold tracking-tight text-slate-900 sm:text-2xl">
                        {{ $lecturer->name }}
                    </h2>

                    <dl class="mt-4 grid gap-3 text-sm text-slate-700 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">NIDN</dt>
                            <dd class="mt-1">{{ $lecturer->nidn ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email</dt>
                            <dd class="mt-1">{{ $lecturer->email ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Telepon</dt>
                            <dd class="mt-1">{{ $lecturer->phone ?: '-' }}</dd>
                        </div>
                    </dl>

                    @if (filled($lecturer->bio))
                        <div class="mt-6 space-y-4 text-[15px] leading-7 text-slate-700">
                            {!! nl2br(e((string) $lecturer->bio)) !!}
                        </div>
                    @endif
                </div>
            </div>
        </article>
    </x-section>
@endsection
