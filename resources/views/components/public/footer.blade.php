@props(['tenant'])

<footer class="bg-slate-50 ring-1 ring-slate-200">
    <div class="mx-auto w-full max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-8 md:grid-cols-2 md:items-start">
            <div class="space-y-2">
                <p class="text-sm font-semibold text-slate-900">{{ $tenant->name }}</p>
                <p class="text-sm text-slate-600">{{ config('app.university_name', 'Universitas Batam') }}</p>
            </div>

            <div class="space-y-3">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Kontak Program Studi</p>

                <ul class="space-y-2 text-sm text-slate-700">
                    <li class="flex items-start gap-2">
                        <x-public.icon name="mail" class="mt-0.5 h-4 w-4 text-primary-600" />
                        <div class="min-w-0">
                            @if (filled($tenant->email))
                                <a href="mailto:{{ $tenant->email }}"
                                    class="break-all font-medium text-primary-600 hover:text-primary-500">
                                    {{ $tenant->email }}
                                </a>
                            @else
                                <p class="italic text-slate-500">Belum tersedia</p>
                            @endif
                        </div>
                    </li>

                    <li class="flex items-start gap-2">
                        <x-public.icon name="phone" class="mt-0.5 h-4 w-4 text-primary-600" />
                        <div>
                            @if (filled($tenant->phone))
                                <p class="text-slate-900">{{ $tenant->phone }}</p>
                            @else
                                <p class="italic text-slate-500">Belum tersedia</p>
                            @endif
                        </div>
                    </li>

                    <li class="flex items-start gap-2">
                        <x-public.icon name="map-pin" class="mt-0.5 h-4 w-4 text-primary-600" />
                        <div>
                            @if (filled($tenant->address))
                                <p class="text-slate-900">{{ $tenant->address }}</p>
                            @else
                                <p class="italic text-slate-500">Belum tersedia</p>
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-10 border-t border-slate-200 pt-6">
            <div class="flex flex-col gap-2 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
                <p>© {{ now()->year }} {{ $tenant->name }}.</p>
                <p>{{ config('app.university_name', 'Universitas Batam') }}</p>
            </div>
        </div>
    </div>
</footer>
