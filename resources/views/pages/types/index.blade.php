@extends('layouts.app')

@section('title', '16 Tipe Kepribadian — MBTI Insight')

@section('content')
    <div class="shell pt-12">
        <section class="relative overflow-hidden rounded-card border border-line bg-white/70 px-6 py-10 sm:px-10">
            <div class="pointer-events-none absolute -top-24 -right-16 h-64 w-64 rounded-full bg-lilac/40" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -bottom-28 -left-20 h-72 w-72 rounded-full bg-blush/35" aria-hidden="true"></div>
            <div class="decor-dots pointer-events-none absolute inset-0 opacity-30" aria-hidden="true"></div>

            <div class="relative max-w-3xl">
                <span class="eyebrow">Ensiklopedia tipe</span>
                <h1 class="heading-xl mt-5">Enam belas perspektif, satu peta yang sama.</h1>
                <p class="prose-soft mt-4">
                    Setiap tipe adalah kombinasi empat preferensi. Tidak ada yang lebih baik — yang ada hanyalah cara kerja
                    yang berbeda dan konteks yang berbeda.
                </p>

                <div class="mt-6 flex flex-wrap gap-2">
                    <span class="chip-lilac">Analis &amp; Diplomat</span>
                    <span class="chip-sky">Sentinel &amp; Explorer</span>
                    <span class="chip-blush">16 karakter chibi</span>
                </div>
            </div>
        </section>

        <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @foreach (config('mbti.dimensions') as $key => $dimension)
                <div class="surface-muted p-5">
                    <x-dimension-label :label="$dimension['label']" :tone="$dimension['tone']" size="sm" />
                    <p class="heading-md mt-3">{{ $dimension['title'] }}</p>
                    <p class="prose-soft mt-2 text-xs">{{ $dimension['poles'][$dimension['left']] }} · {{ $dimension['poles'][$dimension['right']] }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-12 flex flex-wrap items-end justify-between gap-3">
            <div>
                <h2 class="heading-lg">Pilih karaktermu</h2>
                <p class="prose-soft mt-2 text-sm">Setiap kartu memuat satu chibi dengan properti khas tipe tersebut.</p>
            </div>
            <a href="{{ route('compatibility.index') }}" class="text-xs font-medium text-ink-muted transition-colors hover:text-ink">
                Bandingkan dua tipe →
            </a>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            @foreach ($types as $type)
                <x-type-card :type="$type" :index="$loop->iteration" />
            @endforeach
        </div>

        <section class="relative mt-12 overflow-hidden rounded-card border border-lilac/40 bg-gradient-to-br from-lilac-soft via-white to-sky-soft/70 p-8 text-center sm:p-10">
            <div class="pointer-events-none absolute -top-10 -left-10 h-32 w-32 rounded-full bg-blush/40" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -right-8 -bottom-12 h-36 w-36 rounded-full bg-sky/40" aria-hidden="true"></div>

            <div class="relative">
                <h2 class="heading-lg">Belum tahu posisimu di peta ini?</h2>
                <p class="prose-soft mx-auto mt-3 max-w-lg">Empat puluh pernyataan, sekitar sepuluh menit, tanpa perlu akun.</p>
                <a href="{{ route('test.create') }}" class="btn-primary mt-6">Mulai tes</a>
            </div>
        </section>
    </div>
@endsection
