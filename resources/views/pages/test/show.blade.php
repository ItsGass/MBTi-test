@extends('layouts.app')

@section('title', 'Tes Berlangsung — MBTI Insight')

@push('styles')
    <style>
        .js-ready .test-page:not([data-active='true']) {
            display: none;
        }
    </style>
@endpush

@section('content')
    <div class="shell pt-8">
        <div class="surface sticky top-20 z-30 p-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold tracking-[0.16em] text-ink-muted uppercase">
                        {{ $userTest->name }} · Halaman <span data-current-page>{{ $activePage }}</span> dari {{ $pages->count() }}
                    </p>
                    <p class="mt-1 text-sm text-ink-soft">
                        <span data-answered-count>{{ $userTest->answered_count }}</span> dari {{ $userTest->total_questions }} pernyataan terjawab
                    </p>
                </div>
                <span data-save-indicator class="chip bg-white text-[0.7rem] text-ink-muted">Tersimpan otomatis</span>
            </div>

            <div class="mt-4 h-2 overflow-hidden rounded-pill bg-line/60">
                <div data-progress-bar class="h-full rounded-pill bg-gradient-to-r from-lilac via-blush to-sky transition-all duration-500 ease-soft"
                     style="width: {{ $userTest->progressPercent() }}%"></div>
            </div>
        </div>

        <form
            id="test-form"
            method="POST"
            action="{{ route('test.submit', $userTest) }}"
            data-test-form
            data-save-url="{{ route('test.answers', $userTest) }}"
            data-active-page="{{ $activePage }}"
            data-total="{{ $userTest->total_questions }}"
            class="mt-6"
        >
            @csrf

            @if ($errors->any())
                <div class="mb-5 rounded-2xl border border-blush/50 bg-blush-soft/70 px-5 py-4 text-sm text-ink">
                    {{ $errors->first() }}
                </div>
            @endif

            @foreach ($pages as $pageIndex => $answers)
                <section
                    class="test-page animate-fade space-y-4"
                    data-page="{{ $pageIndex + 1 }}"
                    @if ($pageIndex + 1 === $activePage) data-active="true" @endif
                >
                    @foreach ($answers as $answer)
                        <x-question-card :answer="$answer" />
                    @endforeach
                </section>
            @endforeach

            <div class="sticky bottom-4 z-30 mt-8">
                <div class="surface flex items-center justify-between gap-3 px-4 py-3">
                    <button type="button" data-nav="prev" class="btn-ghost text-sm">
                        <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M13 8H4M8 4 4 8l4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Sebelumnya
                    </button>

                    <p class="hidden text-xs text-ink-muted sm:block" data-nav-hint>
                        Lima pernyataan per halaman
                    </p>

                    <div class="flex items-center gap-2">
                        <button type="button" data-nav="next" class="btn-primary text-sm">
                            Lanjut
                            <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                <path d="M3 8h9M8 4l4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>

                        <button type="submit" data-submit class="btn-primary text-sm">
                            Lihat hasil
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
