<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'MBTI Insight membantu kamu mengenali tipe kepribadian, cara mengambil keputusan, dan kecocokan dengan tipe lain lewat tes 40 pernyataan.')">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="MBTI Insight">
    <meta property="og:title" content="@yield('title', 'MBTI Insight — Kenali Dirimu')">
    <meta property="og:description" content="@yield('meta_description', 'Tes kepribadian 40 pernyataan dengan hasil tipe, persentase dimensi, kecocokan, dan sertifikat.')">
    <title>@yield('title', 'MBTI Insight — Kenali Dirimu')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen antialiased">
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:rounded-pill focus:bg-ink focus:px-5 focus:py-3 focus:text-sm focus:font-medium focus:text-cream">
        Lompat ke konten utama
    </a>

    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-40 -left-32 h-96 w-96 rounded-full bg-lilac-soft blur-3xl"></div>
        <div class="absolute top-24 -right-24 h-80 w-80 rounded-full bg-blush-soft blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 h-72 w-72 rounded-full bg-sky-soft blur-3xl"></div>
    </div>

    <header class="sticky top-0 z-40 border-b border-line/70 bg-cream/85 backdrop-blur">
        <div class="shell flex h-16 items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="group flex items-center gap-2.5">
                <span class="flex h-9 w-9 items-center justify-center rounded-2xl bg-ink text-sm font-semibold text-cream transition-transform duration-300 group-hover:-rotate-6">
                    M
                </span>
                <span class="text-sm font-semibold tracking-tight text-ink">
                    MBTI <span class="font-normal text-ink-muted">Insight</span>
                </span>
            </a>

            <nav class="hidden items-center gap-1 sm:flex" aria-label="Navigasi utama">
                <a href="{{ route('home') }}" @class(['nav-link', 'nav-link-active' => request()->routeIs('home')])>Beranda</a>
                <a href="{{ route('types.index') }}" @class(['nav-link', 'nav-link-active' => request()->routeIs('types.*')])>16 Tipe</a>
                <a href="{{ route('compatibility.index') }}" @class(['nav-link', 'nav-link-active' => request()->routeIs('compatibility.*')])>Kecocokan</a>
            </nav>

            <div class="flex items-center gap-2">
                @if (session('mbti.last_token') && ! request()->routeIs('test.*'))
                    <a href="{{ route('test.show', session('mbti.last_token')) }}" class="hidden text-xs font-medium text-ink-muted underline-offset-4 hover:text-ink hover:underline md:inline">
                        Lanjutkan tes
                    </a>
                @endif
                <a href="{{ route('test.create') }}" class="btn-primary px-5 py-2.5 text-xs sm:text-sm">Mulai Tes</a>
            </div>
        </div>

        <div class="shell flex gap-1 pb-3 sm:hidden" aria-label="Navigasi utama (mobile)">
            <a href="{{ route('home') }}" @class(['nav-link text-xs', 'nav-link-active' => request()->routeIs('home')])>Beranda</a>
            <a href="{{ route('types.index') }}" @class(['nav-link text-xs', 'nav-link-active' => request()->routeIs('types.*')])>16 Tipe</a>
            <a href="{{ route('compatibility.index') }}" @class(['nav-link text-xs', 'nav-link-active' => request()->routeIs('compatibility.*')])>Kecocokan</a>
        </div>
    </header>

    @if (session('status'))
        <div class="shell pt-6">
            <div class="animate-fade rounded-2xl border border-lilac/40 bg-lilac-soft/70 px-5 py-3 text-sm text-ink">
                {{ session('status') }}
            </div>
        </div>
    @endif

    <main id="main-content" class="pb-20">
        @yield('content')
    </main>

    <footer class="border-t border-line/80 bg-white/50">
        <div class="shell flex flex-col gap-4 py-10 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-ink">MBTI Insight</p>
                <p class="prose-soft mt-1 max-w-md text-xs">
                    Tes ini bersifat reflektif, bukan diagnosis psikologis. Gunakan hasilnya sebagai bahan mengenal diri, bukan kotak yang mengunci kamu.
                </p>
            </div>
            <div class="flex flex-wrap gap-2 text-xs">
                <a href="{{ route('compatibility.index') }}" class="nav-link">Kecocokan</a>
                <a href="{{ route('types.index') }}" class="nav-link">Semua Tipe</a>
                <a href="{{ route('test.create') }}" class="nav-link">Mulai Tes</a>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
