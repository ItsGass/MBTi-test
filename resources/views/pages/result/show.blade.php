@extends('layouts.app')

@section('title', 'Hasil Tes '.$result->final_mbti.' — MBTI Insight')
@section('robots', 'noindex, nofollow')

@php
    $accents = ['EI' => 'lilac', 'SN' => 'sky', 'TF' => 'blush', 'JP' => 'ink'];
    $tone = $type?->tonePalette() ?? config('mbti.palette.tones.lilac');
@endphp

@section('content')
    <div class="shell pt-10">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <span class="eyebrow">Hasil tes · {{ $userTest->completed_at->translatedFormat('d F Y') }}</span>
                <h1 class="heading-xl mt-5">
                    Halo, {{ $userTest->name }}.
                </h1>
                <p class="prose-soft mt-3 max-w-xl">
                    Ini peta ringkas cara kamu mengisi energi, menyerap informasi, mengambil keputusan, dan mengatur hidup.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('result.certificate', $userTest) }}" target="_blank" rel="noopener" class="btn-primary text-sm">
                    Unduh sertifikat
                </a>
                <button type="button" class="btn-secondary text-sm" data-copy="{{ route('result.show', $userTest) }}">
                    Salin tautan hasil
                </button>
            </div>
        </div>

        <section class="surface relative mt-8 overflow-hidden">
            <div class="absolute inset-0" style="background: linear-gradient(135deg, {{ $tone['soft'] }} 0%, #FFFFFF 62%);"></div>
            <div class="decor-dots pointer-events-none absolute inset-0 opacity-25" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -top-24 -right-16 h-64 w-64 rounded-full"
                 style="background: {{ $tone['base'] }}; opacity: 0.4;" aria-hidden="true"></div>

            <div class="relative flex flex-col gap-8 p-7 sm:p-9 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-col items-start gap-3">
                    <span class="text-6xl font-bold tracking-tight sm:text-7xl" style="color: {{ $tone['deep'] }};">
                        {{ $result->final_mbti }}
                    </span>
                    <span class="chip-lilac">Kekuatan sinyal {{ $result->clarity }}%</span>
                    @if ($type)
                        <x-chibi :type="$type" :size="132" />
                    @endif
                </div>

                <div class="max-w-2xl">
                    <h2 class="heading-lg">{{ $type?->title ?? 'Tipe '.$result->final_mbti }}</h2>
                    <p class="mt-1 text-xs font-semibold tracking-[0.18em] text-ink-muted uppercase">{{ $type?->alias }}</p>
                    <p class="prose-soft mt-4">{{ $type?->description }}</p>

                    <div class="mt-5 flex flex-wrap gap-2">
                        @foreach ($breakdown as $dimension => $data)
                            <span @class([
                                'chip',
                                'bg-lilac-soft' => $accents[$dimension] === 'lilac',
                                'bg-sky-soft' => $accents[$dimension] === 'sky',
                                'bg-blush-soft' => $accents[$dimension] === 'blush',
                                'bg-ink/5' => $accents[$dimension] === 'ink',
                                'text-ink',
                            ])>
                                {{ $data['left'] }}{{ $data['left_score'] }} /
                                {{ $data['right'] }}{{ $data['right_score'] }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-6 grid gap-4 lg:grid-cols-2">
            <div class="surface p-6 sm:p-7">
                <h2 class="heading-md">Empat dimensi</h2>
                <p class="prose-soft mt-2 text-sm">Persentase menunjukkan kecenderungan, bukan kemampuan.</p>

                <div class="mt-6 space-y-6">
                    @foreach ($breakdown as $dimension => $data)
                        <x-dimension-bar
                            :title="config('mbti.dimensions.'.$dimension.'.title')"
                            :left="$data['left']"
                            :right="$data['right']"
                            :left-score="$data['left_score']"
                            :right-score="$data['right_score']"
                            :is-tie="$data['is_tie']"
                            :accent="$accents[$dimension]"
                        />
                    @endforeach
                </div>

                @if ($result->clarity < 20)
                    <p class="mt-6 rounded-2xl bg-cream-deep/70 px-4 py-3 text-xs text-ink-soft">
                        Jawabanmu cukup seimbang di banyak dimensi. Coba tes ulang saat suasana hati lebih tenang
                        untuk melihat pola yang lebih tegas.
                    </p>
                @endif
            </div>

            <div class="space-y-4">
                <div class="surface p-6 sm:p-7">
                    <h2 class="heading-md">Kekuatanmu</h2>
                    <ul class="mt-4 space-y-2.5">
                        @foreach ($type?->strengths ?? [] as $strength)
                            <li class="flex gap-3 text-sm text-ink-soft">
                                <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-sky"></span>
                                <span>{{ $strength }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="surface p-6 sm:p-7">
                    <h2 class="heading-md">Yang bisa ditumbuhkan</h2>
                    <ul class="mt-4 space-y-2.5">
                        @foreach ($type?->weaknesses ?? [] as $weakness)
                            <li class="flex gap-3 text-sm text-ink-soft">
                                <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-blush"></span>
                                <span>{{ $weakness }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>

        <section class="mt-6 grid gap-4 lg:grid-cols-[1fr_1.1fr]">
            <div class="surface p-6 sm:p-7">
                <h2 class="heading-md">Arah karier yang sering nyaman</h2>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($type?->careers ?? [] as $career)
                        <span class="chip-sky">{{ $career }}</span>
                    @endforeach
                </div>
                <a href="{{ route('types.show', $type) }}" class="btn-secondary mt-6 text-sm">Profil lengkap {{ $result->final_mbti }}</a>
            </div>

            <div class="surface p-6 sm:p-7">
                <div class="flex items-center justify-between gap-3">
                    <h2 class="heading-md">Tiga tipe paling cocok</h2>
                    <a href="{{ route('compatibility.index') }}" class="text-xs font-medium text-ink-muted hover:text-ink">Lihat matriks →</a>
                </div>

                <div class="mt-4 space-y-2.5">
                    @foreach ($matches as $match)
                        <a href="{{ route('compatibility.show', [$result->final_mbti, $match['code']]) }}"
                           class="group flex items-center justify-between gap-3 rounded-2xl border border-line/80 bg-white/60 px-4 py-3 transition-all duration-200 hover:-translate-y-0.5 hover:border-lilac/60 hover:bg-white">
                            <div>
                                <p class="text-sm font-semibold text-ink">
                                    {{ $match['code'] }} · {{ $match['title'] }}
                                </p>
                                <p class="text-xs text-ink-muted">{{ $match['note'] }}</p>
                            </div>
                            <span class="chip-lilac shrink-0">{{ $match['score'] }}%</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <p class="mt-8 text-center text-xs text-ink-muted">
            Tautan hasil ini bersifat permanen. Siapa pun yang memiliki tautannya dapat melihat halaman ini.
        </p>
    </div>
@endsection
