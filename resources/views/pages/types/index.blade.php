@extends('layouts.app')

@section('title', '16 Tipe Kepribadian — MBTI Insight')

@section('content')
    <div class="shell pt-12">
        <span class="eyebrow">Ensiklopedia tipe</span>
        <h1 class="heading-xl mt-5 max-w-3xl">Enam belas perspektif, satu peta yang sama.</h1>
        <p class="prose-soft mt-4 max-w-2xl">
            Setiap tipe adalah kombinasi empat preferensi. Tidak ada yang lebih baik — yang ada hanyalah cara kerja
            yang berbeda dan konteks yang berbeda.
        </p>

        <div class="mt-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @foreach (config('mbti.dimensions') as $key => $dimension)
                <div class="surface-muted p-5">
                    <p class="text-xs font-semibold tracking-[0.18em] text-ink-muted uppercase">{{ $dimension['label'] }}</p>
                    <p class="heading-md mt-2">{{ $dimension['title'] }}</p>
                    <p class="prose-soft mt-2 text-xs">{{ $dimension['poles'][$dimension['left']] }} · {{ $dimension['poles'][$dimension['right']] }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-10 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
            @foreach ($types as $type)
                <x-type-card :type="$type" />
            @endforeach
        </div>

        <section class="mt-12 rounded-card border border-lilac/40 bg-gradient-to-br from-lilac-soft/80 via-white to-blush-soft/60 p-8 text-center sm:p-10">
            <h2 class="heading-lg">Belum tahu posisimu di peta ini?</h2>
            <p class="prose-soft mx-auto mt-3 max-w-lg">Empat puluh pernyataan, sekitar sepuluh menit, tanpa perlu akun.</p>
            <a href="{{ route('test.create') }}" class="btn-primary mt-6">Mulai tes</a>
        </section>
    </div>
@endsection
