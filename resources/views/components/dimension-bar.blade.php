@props([
    'title',
    'left',
    'right',
    'leftScore',
    'rightScore',
    'isTie' => false,
    'accent' => 'lilac',
])

@php
    $accents = [
        'lilac' => 'bg-lilac',
        'sky' => 'bg-sky',
        'blush' => 'bg-blush',
        'mint' => 'bg-mint',
    ];
    $bar = $accents[$accent] ?? $accents['lilac'];
@endphp

<div {{ $attributes->merge(['class' => 'space-y-2.5']) }}>
    <div class="flex items-baseline justify-between gap-3">
        <p class="text-xs font-semibold tracking-[0.16em] text-ink-muted uppercase">{{ $title }}</p>
        @if ($isTie)
            <span class="chip bg-white text-[0.65rem] text-ink-muted">Seimbang</span>
        @endif
    </div>

    <div class="flex items-center gap-3">
        <span class="w-14 text-right text-sm font-semibold text-ink">{{ $left }} {{ $leftScore }}%</span>
        <div class="relative h-3 flex-1 overflow-hidden rounded-pill bg-line/60" role="img"
             aria-label="{{ $left }} {{ $leftScore }} persen, {{ $right }} {{ $rightScore }} persen">
            <div class="absolute inset-y-0 left-0 rounded-pill {{ $bar }} transition-all duration-700 ease-soft"
                 style="width: {{ $leftScore }}%"></div>
            <div class="absolute inset-y-0 left-1/2 w-px bg-white/80"></div>
        </div>
        <span class="w-14 text-sm font-semibold text-ink">{{ $right }} {{ $rightScore }}%</span>
    </div>
</div>
