@extends('public.layouts.app')

@section('content')
    <x-public.page-header eyebrow="Tentang Kami" :title="$tenant->name"
        description="Informasi profil program studi, visi, misi, dan arah pengembangan akademik." :breadcrumbs="[
            [
                'label' => 'Home',
                'href' => route('home'),
            ],
            [
                'label' => 'Tentang',
            ],
        ]" />
    <x-quick-info :tenant="$tenant" />

    <div class="py-10 sm:py-12">
        <x-section id="about" title="Profil Program Studi" subtitle="Gambaran umum serta visi dan misi." tone="default">
            <x-about-section :tenant="$tenant" />
        </x-section>

        <x-section id="contact" title="Kontak Program Studi"
            subtitle="Hubungi kami untuk informasi akademik dan layanan lainnya." tone="muted">
            <x-contact-panel :tenant="$tenant" />
        </x-section>
    </div>
@endsection
