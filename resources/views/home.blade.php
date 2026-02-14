@extends('public.layouts.app')

@section('content')
    <x-hero :tenant="$tenant" />
    <x-quick-info :tenant="$tenant" />

    {{-- <x-section id="program-info" title="Informasi Program" subtitle="Ringkasan profil akademik program studi.">
        <x-quick-info :tenant="$tenant" />
    </x-section> --}}

    <x-section id="about" title="Tentang Program Studi" tone="default">
        <div class="space-y-5">
            <x-about-section :tenant="$tenant" />

            <div class="flex justify-end">
                <a href="{{ route('about') }}"
                    class="inline-flex items-center rounded-lg bg-primary-600 px-3 py-1.5 text-sm font-semibold text-white ring-1 ring-primary-600/20 transition hover:bg-primary-500">
                    <span>Selengkapnya</span>
                    <x-public.icon name="arrow-right" class="ml-2 h-4 w-4" />
                </a>
            </div>
        </div>
    </x-section>


    {{-- <x-section id="highlights" title="Keunggulan Program" subtitle="Poin-poin utama yang menjadi kekuatan program studi.">
        <x-program-highlights :tenant="$tenant" />
    </x-section> --}}

    <x-section id="latest-news" title="Berita Terbaru" subtitle="Publikasi dan aktivitas terbaru dari program studi."
        tone="muted">
        <x-news-teaser :news-items="$latestNews" />
    </x-section>

    <x-section id="facilities" title="Fasilitas" subtitle="Fasilitas pendukung pembelajaran untuk mahasiswa."
        tone="default">
        <x-facilities-teaser :facilities="$featuredFacilities" />
    </x-section>

    <x-section id="lecturers" title="Dosen" subtitle="Sebagian dosen yang terlibat aktif di program studi." tone="muted">
        <x-lecturers-teaser :lecturers="$featuredLecturers" />
    </x-section>
@endsection
