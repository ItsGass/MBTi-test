@extends('layouts.app')

@section('title', $type->code.' '.$type->title.' — MBTI Insight')

@section('content')
    @php
        $bands = config('mbti.compatibility.bands');
        $bandTone = fn (int $score): string => collect($bands)->firstWhere(fn ($band) => $score >= $band['min'])['tone'] ?? 'slate';
    @endphp

    <div class="shell pt-10">
        <a href="{{ route('types.index') }}" class="text-xs font-medium text-ink-muted hover:text-ink">← Semua tipe</a>

        <section class="surface relative mt-5 overflow-hidden p-7 sm:p-9">
            <div class="absolute -top-20 -right-16 h-56 w-56 rounded-full opacity-30 blur-2xl"
                 style="background: {{ $type->accent_color }}"></div>

            <div class="relative flex flex-wrap items-start justify-between gap-6">
                <div>
                    <span class="text-5xl font-bold tracking-tight sm:text-6xl" style="color: {{ $type->accent_color }}">
                        {{ $type->code }}
                    </span>
                    <h1 class="heading-lg mt-3">{{ $type->title }}</h1>
                    <p class="mt-1 text-xs font-semibold tracking-[0.18em] text-ink-muted uppercase">{{ $type->alias }}</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('compatibility.index', ['a' => $type->code]) }}" class="btn-secondary text-sm">Cek kecocokan</a>
                    <a href="{{ route('test.create') }}" class="btn-primary text-sm">Tes dirimu</a>
                </div>
            </div>

            <p class="prose-soft relative mt-6 max-w-3xl">{{ $type->description }}</p>
        </section>

        <section class="mt-6 grid gap-4 lg:grid-cols-2">
            <div class="surface p-6 sm:p-7">
                <h2 class="heading-md">Kekuatan utama</h2>
                <ul class="mt-4 space-y-2.5">
                    @foreach ($type->strengths ?? [] as $strength)
                        <li class="flex gap-3 text-sm text-ink-soft">
                            <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-mint"></span>
                            <span>{{ $strength }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="surface p-6 sm:p-7">
                <h2 class="heading-md">Titik yang perlu dijaga</h2>
                <ul class="mt-4 space-y-2.5">
                    @foreach ($type->weaknesses ?? [] as $weakness)
                        <li class="flex gap-3 text-sm text-ink-soft">
                            <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-blush"></span>
                            <span>{{ $weakness }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        <section class="surface mt-6 p-6 sm:p-7">
            <h2 class="heading-md">Rekomendasi karier</h2>
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach ($type->careers ?? [] as $career)
                    <span class="chip-sky">{{ $career }}</span>
                @endforeach
            </div>
        </section>

        <section class="mt-10 flex flex-wrap items-end justify-between gap-3">
            <div>
                <h2 class="heading-lg">Tipe yang paling sering cocok</h2>
                <p class="prose-soft mt-2 text-sm">Diurutkan dari skor kecocokan tertinggi.</p>
            </div>
        </section>

        <div class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($ranking as $entry)
                <a href="{{ route('compatibility.show', [$type->code, $entry['code']]) }}"
                   class="surface group flex flex-col gap-3 p-5 transition-all duration-300 hover:-translate-y-1 hover:border-lilac/50 hover:shadow-lift">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-sm font-bold tracking-[0.2em] text-ink">{{ $entry['code'] }}</span>
                        <span @class([
                            'chip',
                            'bg-lilac-soft text-ink' => $bandTone($entry['score']) === 'purple',
                            'bg-sky-soft text-ink' => $bandTone($entry['score']) === 'blue',
                            'bg-blush-soft text-ink' => $bandTone($entry['score']) === 'pink',
                            'bg-cream-deep text-ink' => $bandTone($entry['score']) === 'slate',
                        ])>{{ $entry['score'] }}% · {{ $entry['label'] }}</span>
                    </div>

                    <div class="h-2 overflow-hidden rounded-pill bg-line/60">
                        <div class="h-full rounded-pill bg-lilac transition-all duration-500" style="width: {{ $entry['score'] }}%"></div>
                    </div>

                    <p class="text-xs leading-relaxed text-ink-muted">{{ $entry['note'] }}</p>
                </a>
            @endforeach
        </div>

        <section class="mt-10 rounded-card border border-lilac/40 bg-gradient-to-br from-lilac-soft/80 via-white to-mint-soft/60 p-8 text-center">
            <h2 class="heading-lg">Apakah kamu {{ $type->code }}?</h2>
            <p class="prose-soft mx-auto mt-3 max-w-lg">Ikuti tes untuk melihat persentase dimensimu dan mengunduh sertifikat.</p>
            <a href="{{ route('test.create') }}" class="btn-primary mt-6">Mulai tes</a>
        </section>
    </div>
@endsection
