@extends('public.layouts.app')

@section('content')
    <x-public.page-header eyebrow="Fasilitas" title="Sarana dan Prasarana"
        description="Fasilitas pendukung pembelajaran dan aktivitas akademik." :breadcrumbs="[
            [
                'label' => 'Home',
                'href' => route('home'),
            ],
            [
                'label' => 'Fasilitas',
            ],
        ]" />

    <x-section id="facilities" title="Daftar Fasilitas"
        subtitle="Fasilitas yang tersedia untuk mendukung kegiatan belajar mengajar." tone="default">
        <x-facilities-teaser :facilities="$facilities" />

        <div class="mt-8">
            {{ $facilities->links() }}
        </div>
    </x-section>
@endsection
