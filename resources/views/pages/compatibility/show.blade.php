@extends('layouts.app')

@section('title', 'Kecocokan '.$pair['type_a']->code.' × '.$pair['type_b']->code.' — MBTI Insight')

@section('content')
    <div class="shell pt-10">
        <a href="{{ route('compatibility.index') }}" class="text-xs font-medium text-ink-muted hover:text-ink">← Matriks kecocokan</a>

        <section class="surface mt-5 overflow-hidden">
            <div class="grid gap-10 p-7 sm:p-10 lg:grid-cols-[1fr_auto] lg:items-center">
                <div>
                    <span class="eyebrow">Dinamika pasangan</span>

                    <h1 class="heading-xl mt-5 flex flex-wrap items-center gap-3">
                        <span>{{ $pair['type_a']->code }}</span>
                        <span class="text-ink-muted">×</span>
                        <span>{{ $pair['type_b']->code }}</span>
                    </h1>

                    <p class="mt-3 text-sm font-medium text-ink-soft">
                        {{ $pair['type_a']->title }} &amp; {{ $pair['type_b']->title }}
                    </p>

                    <div class="mt-6 flex flex-wrap gap-2">
                        <span class="chip-lilac">{{ $pair['label'] }}</span>
                        @foreach ($overlap['shared'] as $letter)
                            <span class="chip-mint">Sama: {{ $letter }}</span>
                        @endforeach
                        @foreach ($overlap['different'] as $difference)
                            <span class="chip-blush">Beda: {{ $difference }}</span>
                        @endforeach
                    </div>

                    <p class="prose-soft mt-6 max-w-2xl">{{ $pair['note'] }}</p>
                </div>

                <div class="flex items-center justify-center">
                    <div class="relative flex h-40 w-40 items-center justify-center rounded-full"
                         style="background: conic-gradient(var(--color-lilac) {{ $pair['score'] }}%, var(--color-lilac-soft) 0);">
                        <div class="flex h-32 w-32 flex-col items-center justify-center rounded-full bg-cream text-center">
                            <span class="text-4xl font-semibold text-ink">{{ $pair['score'] }}</span>
                            <span class="mt-1 text-[0.65rem] font-medium tracking-[0.14em] text-ink-muted uppercase">dari 100</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-6 grid gap-4 lg:grid-cols-2">
            @foreach ([$pair['type_a'], $pair['type_b']] as $type)
                <article class="surface p-6 sm:p-7">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-bold tracking-[0.2em]" style="color: {{ $type->accent_color }}">{{ $type->code }}</p>
                            <h2 class="heading-md mt-2">{{ $type->title }}</h2>
                            <p class="mt-1 text-[0.7rem] font-medium tracking-[0.16em] text-ink-muted uppercase">{{ $type->alias }}</p>
                        </div>
                        <a href="{{ route('types.show', $type) }}" class="chip bg-white text-ink-muted hover:text-ink">Profil</a>
                    </div>

                    <p class="prose-soft mt-4 text-sm">{{ $type->description }}</p>

                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach (array_slice($type->strengths ?? [], 0, 2) as $strength)
                            <span class="chip bg-cream-deep text-[0.7rem] text-ink-soft">{{ $strength }}</span>
                        @endforeach
                    </div>
                </article>
            @endforeach
        </section>

        <section class="surface mt-6 p-6 sm:p-7">
            <h2 class="heading-md">Cara membaca skor ini</h2>
            <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach (config('mbti.compatibility.bands') as $band)
                    <div class="rounded-2xl border border-line/80 bg-white/60 p-4">
                        <p class="text-lg font-semibold text-ink">{{ $band['min'] }}+</p>
                        <p class="mt-1 text-sm text-ink-soft">{{ $band['label'] }}</p>
                    </div>
                @endforeach
            </div>
            <p class="prose-soft mt-5 text-xs">
                Skor tinggi bukan jaminan hubungan berjalan mulus, dan skor rendah bukan alasan untuk menjauh.
                Kecocokan hanya menggambarkan kemudahan awal, bukan hasil akhir.
            </p>
        </section>

        <section class="mt-6 rounded-card border border-lilac/40 bg-gradient-to-br from-lilac-soft/80 via-white to-sky-soft/60 p-8 text-center">
            <h2 class="heading-lg">Mau tahu tipe dan kecocokanmu sendiri?</h2>
            <a href="{{ route('test.create') }}" class="btn-primary mt-5">Mulai tes 40 pernyataan</a>
        </section>
    </div>
@endsection
