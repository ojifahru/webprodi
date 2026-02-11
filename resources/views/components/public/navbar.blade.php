@props(['tenant'])

@php
    $logoPath = $tenant->logo_path ?? null;
    $logoUrl = null;

    if (filled($logoPath)) {
        if (\Illuminate\Support\Str::startsWith($logoPath, ['http://', 'https://', '/'])) {
            $logoUrl = $logoPath;
        } elseif (\Illuminate\Support\Str::startsWith($logoPath, 'storage/')) {
            $logoUrl = asset($logoPath);
        } else {
            $logoUrl = asset('storage/' . $logoPath);
        }
    }

    $homeUrl = route('home');

    $items = [
        [
            'label' => 'Home',
            'href' => $homeUrl,
            'active' => request()->routeIs('home'),
        ],
        [
            'label' => 'Tentang',
            'href' => route('about'),
            'active' => request()->routeIs('about'),
        ],
        [
            'label' => 'Berita',
            'href' => route('news.index'),
            'active' => request()->routeIs('news.*'),
        ],
        [
            'label' => 'Fasilitas',
            'href' => route('facilities.index'),
            'active' => request()->routeIs('facilities.*'),
        ],
        [
            'label' => 'Kontak Kami',
            'href' => route('contact'),
            'active' => request()->routeIs('contact'),
        ],
    ];
@endphp

<header class="sticky top-0 z-50 bg-white/90 backdrop-blur ring-1 ring-slate-200 shadow-sm">
    <div class="mx-auto flex w-full max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ $homeUrl }}" class="inline-flex min-w-0 items-center gap-3" aria-label="Home">
            @if ($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $tenant->name }} logo"
                    class="h-11 w-11 shrink-0 rounded-2xl object-cover shadow-sm ring-1 ring-slate-200" />
            @else
                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-primary-600 text-base font-semibold text-white">
                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($tenant->name, 0, 1)) }}
                </div>
            @endif

            <div class="min-w-0 leading-tight">
                <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-slate-500">Program Studi</p>
                <p class="truncate text-base font-semibold text-slate-900 sm:text-lg">{{ $tenant->name }}</p>
            </div>
        </a>

        <nav aria-label="Primary" class="hidden md:block">
            <ul class="flex items-center gap-6 text-sm font-medium text-slate-600">
                @foreach ($items as $item)
                    <li>
                        <a href="{{ $item['href'] }}" @class([
                            'relative inline-flex items-center py-2 text-sm font-semibold transition',
                            'text-slate-600 hover:text-primary-600' => !$item['active'],
                            'text-primary-600 after:absolute after:-bottom-0.5 after:left-0 after:right-0 after:h-0.5 after:rounded-full after:bg-primary-600' =>
                                $item['active'],
                        ])>
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <button type="button" data-navbar-toggle aria-controls="public-navbar-mobile" aria-expanded="false"
            class="inline-flex items-center justify-center rounded-2xl bg-white p-2 text-slate-700 shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-50 md:hidden">
            <span class="sr-only">Buka menu</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M2 5.25A.75.75 0 012.75 4.5h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 5.25zm0 4.5A.75.75 0 012.75 9h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 9.75zm0 4.5a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <div id="public-navbar-mobile" data-navbar-menu class="md:hidden hidden">
        <div class="mx-auto w-full max-w-6xl px-4 pb-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-white/95 p-3 shadow-sm ring-1 ring-slate-200 backdrop-blur">
                <ul class="space-y-1 text-sm font-medium text-slate-700">
                    @foreach ($items as $item)
                        <li>
                            <a href="{{ $item['href'] }}" @class([
                                'block rounded-2xl px-4 py-3 transition',
                                'hover:bg-slate-50 hover:text-slate-900' => !$item['active'],
                                'bg-primary-50 text-primary-600 ring-1 ring-primary-600/15' =>
                                    $item['active'],
                            ])>
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script>
        (() => {
            const toggle = document.querySelector('[data-navbar-toggle]');
            const menu = document.querySelector('[data-navbar-menu]');

            if (!toggle || !menu) {
                return;
            }

            const setExpanded = (expanded) => {
                toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
                menu.classList.toggle('hidden', !expanded);
            };

            setExpanded(false);

            toggle.addEventListener('click', () => {
                const expanded = toggle.getAttribute('aria-expanded') === 'true';
                setExpanded(!expanded);
            });

            menu.addEventListener('click', (event) => {
                const target = event.target;
                if (target instanceof HTMLAnchorElement) {
                    setExpanded(false);
                }
            });
        })();
    </script>
</header>
