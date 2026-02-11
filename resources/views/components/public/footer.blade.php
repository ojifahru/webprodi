@props(['tenant'])

<footer class="bg-slate-50 ring-1 ring-slate-200">
    <div class="mx-auto w-full max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-8 md:grid-cols-2 md:items-start">
            <div class="space-y-2">
                <p class="text-sm  text-slate-900">{{ $tenant->name }}</p>
                <p class="text-sm text-slate-600">{{ config('app.university_name', 'Universitas Batam') }}</p>
            </div>

            <div class="space-y-3">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Kontak Program Studi</p>

                <ul class="space-y-2 text-sm text-slate-700">
                    <li class="flex items-start gap-2">
                        <x-public.icon name="mail" class="mt-0.5 h-4 w-4 text-primary-600" />
                        <div>
                            <p class="font-medium text-slate-900">
                                @if (filled($tenant->email))
                                    <a href="mailto:{{ $tenant->email }}"
                                        class="text-primary-600 hover:text-primary-500">
                                        {{ $tenant->email }}
                                    </a>
                                @else
                                    <p class="text-slate-600">Belum tersedia</p>
                                @endif
                            </p>
                        </div>
                    </li>

                    <li class="flex items-start gap-2">
                        <x-public.icon name="phone" class="mt-0.5 h-4 w-4 text-primary-600" />
                        <div>
                            <p class="text-slate-900">{{ $tenant->phone ?: 'Belum tersedia' }}</p>
                        </div>
                    </li>

                    <li class="flex items-start gap-2">
                        <x-public.icon name="map-pin" class="mt-0.5 h-4 w-4 text-primary-600" />
                        <div>
                            <p class="text-slate-900">{{ $tenant->address ?: 'Belum tersedia' }}</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
