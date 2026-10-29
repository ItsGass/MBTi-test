@extends('layouts.app')

@section('title', 'Sesi Kedaluwarsa — MBTI Insight')

@section('content')
    <section class="shell flex min-h-[60vh] items-center justify-center py-16">
        <div class="surface animate-rise max-w-xl p-8 text-center sm:p-10">
            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blush-soft text-2xl">⏳</span>

            <h1 class="heading-lg mt-6">Sesi tes ini sudah kedaluwarsa</h1>
            <p class="prose-soft mt-4">
                Halo {{ $userTest->name }}, tes yang dimulai pada
                {{ $userTest->started_at->translatedFormat('d F Y, H.i') }} hanya bisa dilanjutkan selama
                {{ config('mbti.session_ttl_hours') }} jam. Jawaban lama tidak bisa dipulihkan, tapi kamu bisa
                memulai tes baru kapan saja.
            </p>

            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('test.create') }}" class="btn-primary">Mulai tes baru</a>
                <a href="{{ route('home') }}" class="btn-secondary">Kembali ke beranda</a>
            </div>
        </div>
    </section>
@endsection
