@extends('public.layouts.app')

@section('content')
    <x-public.page-header eyebrow="Fasilitas" :title="$facility->name"
        description="Detail fasilitas pendukung pembelajaran dan aktivitas akademik." :breadcrumbs="[
            [
                'label' => 'Home',
                'href' => route('home'),
            ],
            [
                'label' => 'Fasilitas',
                'href' => route('facilities.index'),
            ],
            [
                'label' => $facility->name,
            ],
        ]" />

    @php
        $imagePath = $facility->image_path ?? null;
        $imageUrl = null;

        if (filled($imagePath)) {
            if (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://', '/'])) {
                $imageUrl = $imagePath;
            } elseif (\Illuminate\Support\Str::startsWith($imagePath, 'storage/')) {
                $imageUrl = asset($imagePath);
            } else {
                $imageUrl = asset('storage/' . $imagePath);
            }
        }
    @endphp

    <x-section id="facility-detail" title="Deskripsi" subtitle="Informasi lengkap fasilitas." tone="default">
        <article class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
            @if ($imageUrl)
                <img src="{{ $imageUrl }}" alt="{{ $facility->name }}" class="h-64 w-full object-cover sm:h-80" />
            @endif

            <div class="p-6 sm:p-8">
                <header class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                    <div class="min-w-0">
                        <h2 class="text-xl font-semibold tracking-tight text-slate-900 sm:text-2xl">
                            {{ $facility->name }}
                        </h2>
                    </div>

                    <div class="shrink-0">
                        <a href="{{ route('facilities.index') }}"
                            class="text-sm font-semibold text-primary-600 hover:text-primary-500">
                            Kembali ke daftar
                        </a>
                    </div>
                </header>

                <div class="mt-6 space-y-4 text-[15px] leading-7 text-slate-700">
                    @if (filled($facility->description))
                        {!! nl2br(e((string) $facility->description)) !!}
                    @else
                        <p class="italic text-slate-500">Deskripsi fasilitas belum tersedia.</p>
                    @endif
                </div>
            </div>
        </article>
    </x-section>
@endsection
