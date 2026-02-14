@extends('public.layouts.app')

@section('content')
    <x-public.page-header eyebrow="Kontak Kami" title="Hubungi Program Studi"
        description="Silakan hubungi kami untuk informasi akademik, layanan mahasiswa, dan kerja sama." :breadcrumbs="[
            [
                'label' => 'Home',
                'href' => route('home'),
            ],
            [
                'label' => 'Kontak Kami',
            ],
        ]" />

    <x-section id="contact" title="Kontak" subtitle="Informasi kontak resmi program studi." tone="default">
        <x-contact-panel :tenant="$tenant" />
    </x-section>
@endsection
