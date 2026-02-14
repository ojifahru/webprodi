@extends('public.layouts.app')

@section('content')
    <x-public.page-header eyebrow="Berita" title="Info Terbaru"
        description="Publikasi dan aktivitas terbaru dari program studi." :breadcrumbs="[
            [
                'label' => 'Home',
                'href' => route('home'),
            ],
            [
                'label' => 'Berita',
            ],
        ]" />

    <x-section id="latest-news" title="Daftar Berita" subtitle="Informasi terbaru yang dipublikasikan oleh program studi."
        tone="default">
        <x-news-teaser :news-items="$newsItems" />

        <div class="mt-8">
            {{ $newsItems->links() }}
        </div>
    </x-section>
@endsection
