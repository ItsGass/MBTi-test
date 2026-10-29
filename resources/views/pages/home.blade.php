@extends('layouts.app')

@section('title', 'MBTI Insight — Kenali Dirimu')

@section('content')
    <section class="shell grid gap-12 pt-14 pb-16 lg:grid-cols-[1.15fr_0.85fr] lg:items-center lg:pt-20">
        <div class="animate-rise">
            <span class="eyebrow">Tes kepribadian · 40 pernyataan</span>

            <h1 class="heading-xl mt-6">
                Kenali caramu<br class="hidden sm:block">
                <span class="text-lilac">berpikir, merasa,</span> dan memilih.
            </h1>

            <p class="prose-soft mt-6 max-w-xl">
                MBTI Insight memetakan empat dimensi kepribadianmu lewat pernyataan sederhana berskala lima.
                Hasilnya bukan kotak yang mengunci, tapi peta kecil untuk memahami ritme diri dan orang lain.
            </p>

            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a href="{{ route('test.create') }}" class="btn-primary">
                    Mulai tes sekarang
                    <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M3 8h9M8 4l4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="{{ route('types.index') }}" class="btn-secondary">Jelajahi 16 tipe</a>
            </div>

            <dl class="mt-10 grid max-w-lg grid-cols-3 gap-3">
                <div class="stat-card">
                    <dt class="text-[0.65rem] font-semibold tracking-[0.14em] text-ink-muted uppercase">Durasi</dt>
                    <dd class="mt-2 text-lg font-semibold text-ink">± 10 menit</dd>
                </div>
                <div class="stat-card">
                    <dt class="text-[0.65rem] font-semibold tracking-[0.14em] text-ink-muted uppercase">Halaman</dt>
                    <dd class="mt-2 text-lg font-semibold text-ink">8 halaman</dd>
                </div>
                <div class="stat-card">
                    <dt class="text-[0.65rem] font-semibold tracking-[0.14em] text-ink-muted uppercase">Sertifikat</dt>
                    <dd class="mt-2 text-lg font-semibold text-ink">PNG</dd>
                </div>
            </dl>
        </div>

        <div class="animate-rise [animation-delay:120ms]">
            <div class="surface relative overflow-hidden p-7">
                <div class="absolute -top-16 -right-12 h-40 w-40 rounded-full bg-lilac-soft blur-2xl"></div>

                <p class="relative text-xs font-semibold tracking-[0.18em] text-ink-muted uppercase">Empat dimensi</p>

                <ul class="relative mt-5 space-y-3">
                    @foreach (config('mbti.dimensions') as $key => $dimension)
                        <li class="flex items-start gap-3 rounded-2xl border border-line/70 bg-white/70 p-4 transition-colors duration-300 hover:border-ink/15">
                            <x-dimension-label :label="$dimension['label']" :tone="$dimension['tone']" />
                            <div>
                                <p class="text-sm font-semibold text-ink">{{ $dimension['title'] }}</p>
                                <p class="mt-0.5 text-xs leading-relaxed text-ink-muted">{{ $dimension['description'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    <section class="shell pb-16">
        <div class="grid gap-4 sm:grid-cols-3">
            @foreach ([
                ['01', 'Isi nama', 'Cukup nama panggilan. Umur opsional, tidak dipaksa.'],
                ['02', 'Jawab 40 pernyataan', 'Lima jawaban per halaman, progres tersimpan otomatis.'],
                ['03', 'Dapatkan hasil', 'Tipe, persentase dimensi, kecocokan, dan sertifikat PNG.'],
            ] as [$step, $title, $copy])
                <article class="surface p-6 transition-all duration-300 hover:-translate-y-1 hover:border-lilac/50 hover:shadow-lift">
                    <span class="text-xs font-semibold tracking-[0.2em] text-lilac">{{ $step }}</span>
                    <h2 class="heading-md mt-3">{{ $title }}</h2>
                    <p class="prose-soft mt-2 text-sm">{{ $copy }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="shell pb-16">
        <div class="flex flex-wrap items-end justify-between gap-3">
            <div>
                <span class="eyebrow">Peta tipe</span>
                <h2 class="heading-lg mt-4">Enam belas cara unik melihat dunia</h2>
            </div>
            <a href="{{ route('types.index') }}" class="nav-link text-sm">Lihat semua →</a>
        </div>

        <div class="mt-8 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
            @foreach ($types as $type)
                <x-type-card :type="$type" :index="$loop->iteration" />
            @endforeach
        </div>
    </section>

    <section class="shell pb-20">
        <div class="surface overflow-hidden">
            <div class="grid gap-8 p-8 lg:grid-cols-[1fr_auto] lg:items-center lg:p-10">
                <div>
                    <span class="eyebrow">Sorotan kecocokan</span>
                    <h2 class="heading-lg mt-4">
                        {{ $spotlight['type_a']->code }} <span class="text-ink-muted">×</span> {{ $spotlight['type_b']->code }}
                    </h2>
                    <p class="prose-soft mt-3 max-w-xl">
                        {{ $spotlight['type_a']->title }} bertemu {{ $spotlight['type_b']->title }}.
                        {{ $spotlight['note'] }}
                    </p>
                    <a href="{{ route('compatibility.show', [$spotlight['type_a'], $spotlight['type_b']]) }}" class="btn-secondary mt-6">
                        Lihat dinamika lengkap
                    </a>
                </div>

                <div class="flex items-center justify-center">
                    <div class="relative flex h-36 w-36 items-center justify-center rounded-full"
                         style="background: conic-gradient(var(--color-lilac) {{ $spotlight['score'] }}%, var(--color-lilac-soft) 0);">
                        <div class="flex h-28 w-28 flex-col items-center justify-center rounded-full bg-cream">
                            <span class="text-3xl font-semibold text-ink">{{ $spotlight['score'] }}</span>
                            <span class="text-[0.65rem] font-medium tracking-[0.12em] text-ink-muted uppercase">{{ $spotlight['label'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="shell">
        <div class="rounded-card border border-lilac/40 bg-gradient-to-br from-lilac-soft/80 via-white to-blush-soft/70 p-8 text-center sm:p-12">
            <h2 class="heading-lg">Siap melihat versi dirimu yang lebih jelas?</h2>
            <p class="prose-soft mx-auto mt-3 max-w-xl">
                Tidak perlu membuat akun. Hasilmu tersimpan pada tautan pribadi yang bisa kamu buka kapan saja.
            </p>
            <a href="{{ route('test.create') }}" class="btn-primary mt-7">Mulai tes — gratis</a>
        </div>
    </section>
@endsection
