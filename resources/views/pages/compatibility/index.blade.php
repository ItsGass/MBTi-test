@extends('layouts.app')

@section('title', 'Matriks Kecocokan 16 Tipe — MBTI Insight')

@section('content')
    <div class="shell pt-12">
        <span class="eyebrow">Matriks 16 × 16</span>
        <h1 class="heading-xl mt-5 max-w-3xl">Bagaimana dua tipe bekerja saat berdekatan?</h1>
        <p class="prose-soft mt-4 max-w-2xl">
            Setiap pasangan punya skor kecocokan 0–100 yang dihitung dari dimensi yang sama dan yang saling melengkapi.
            Pilih dua tipe untuk melihat dinamikanya.
        </p>

        <form method="GET" action="{{ route('compatibility.index') }}" class="surface mt-8 grid gap-4 p-6 sm:grid-cols-[1fr_auto_1fr_auto] sm:items-end">
            <div>
                <label for="a" class="field-label">Tipe pertama</label>
                <select id="a" name="a" class="field">
                    @foreach ($types as $type)
                        <option value="{{ $type->code }}" @selected($type->code === $selectedLeft)>
                            {{ $type->code }} — {{ $type->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="hidden pb-3 text-center text-sm font-semibold text-ink-muted sm:block">×</div>

            <div>
                <label for="b" class="field-label">Tipe kedua</label>
                <select id="b" name="b" class="field">
                    @foreach ($types as $type)
                        <option value="{{ $type->code }}" @selected($type->code === $selectedRight)>
                            {{ $type->code }} — {{ $type->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-primary">Lihat kecocokan</button>
        </form>

        <div class="mt-12 flex flex-wrap items-end justify-between gap-3">
            <h2 class="heading-lg">Jelajahi tiap tipe</h2>
            <a href="{{ route('types.index') }}" class="text-xs font-medium text-ink-muted hover:text-ink">Profil lengkap →</a>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
            @foreach ($types as $type)
                <x-type-card :type="$type" :index="$loop->iteration" />
            @endforeach
        </div>
    </div>
@endsection
