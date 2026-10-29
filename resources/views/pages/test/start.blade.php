@extends('layouts.app')

@section('title', 'Mulai Tes — MBTI Insight')

@section('content')
    <section class="shell grid gap-10 pt-14 pb-16 lg:grid-cols-[1fr_0.85fr] lg:items-start">
        <div class="animate-rise">
            <span class="eyebrow">Langkah 1 dari 3</span>
            <h1 class="heading-xl mt-6">Sebelum mulai,<br>siapa namamu?</h1>
            <p class="prose-soft mt-5 max-w-lg">
                Nama akan tercetak di sertifikat hasil tes. Umur bersifat opsional — kamu bisa mengosongkannya
                kalau ingin langsung mulai.
            </p>

            <form method="POST" action="{{ route('test.store') }}" class="surface mt-8 max-w-lg space-y-5 p-6 sm:p-7">
                @csrf

                <div>
                    <label for="name" class="field-label">Nama panggilan</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="80"
                           autocomplete="given-name" placeholder="Contoh: Dityo" class="field" autofocus>
                    @error('name')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="age" class="field-label">
                        Umur <span class="font-normal text-ink-muted">(opsional)</span>
                    </label>
                    <input id="age" name="age" type="number" value="{{ old('age') }}" min="10" max="99"
                           inputmode="numeric" placeholder="Contoh: 21" class="field">
                    @error('age')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                    <p class="field-hint">Rentang 10–99 tahun. Tidak digunakan untuk menilai hasil.</p>
                </div>

                <button type="submit" class="btn-primary w-full">
                    Mulai 40 pernyataan
                    <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M3 8h9M8 4l4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <p class="text-center text-xs text-ink-muted">
                    Tanpa akun. Progres tersimpan otomatis selama 24 jam.
                </p>
            </form>
        </div>

        <aside class="animate-rise space-y-4 [animation-delay:120ms]">
            <div class="surface p-6">
                <p class="text-xs font-semibold tracking-[0.18em] text-ink-muted uppercase">Yang perlu kamu tahu</p>
                <ul class="mt-4 space-y-3 text-sm text-ink-soft">
                    @foreach ([
                        'Jawab spontan, bukan versi ideal dirimu.',
                        'Lima pernyataan per halaman, total 8 halaman.',
                        'Bisa ditinggal dan dilanjutkan lewat tautan yang sama.',
                        'Hasil berupa tipe, persentase dimensi, dan sertifikat PNG.',
                    ] as $point)
                        <li class="flex gap-3">
                            <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-lilac"></span>
                            <span>{{ $point }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="surface-muted p-6">
                <p class="text-xs font-semibold tracking-[0.18em] text-ink-muted uppercase">Skala jawaban</p>
                <div class="mt-4 space-y-2">
                    @foreach (config('mbti.likert.labels') as $value => $label)
                        <div class="flex items-center gap-3 text-sm">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-white text-xs font-semibold text-ink">
                                {{ $value }}
                            </span>
                            <span class="text-ink-soft">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </aside>
    </section>
@endsection
