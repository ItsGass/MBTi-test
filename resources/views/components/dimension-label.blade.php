@props([
    'label',
    'tone' => 'lilac',
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'h-8 w-12 rounded-lg text-[0.7rem]',
        'md' => 'h-10 w-14 rounded-xl text-sm',
    ];
    $shape = $sizes[$size] ?? $sizes['md'];
    $swatch = 'bg-lilac border-lilac-deep/40';
@endphp

@switch($tone)
    @case('blush')
        @php $swatch = 'bg-blush border-blush-deep/40'; @endphp
        @break

    @case('sky')
        @php $swatch = 'bg-sky border-sky-deep/40'; @endphp
        @break

    @case('mint')
        @php $swatch = 'bg-mint border-mint-deep/40'; @endphp
        @break

    @default
        @php $swatch = 'bg-lilac border-lilac-deep/40'; @endphp
@endswitch

<span {{ $attributes->merge(['class' => "flex shrink-0 items-center justify-center border font-semibold tracking-wider text-ink {$shape} {$swatch}"]) }}>
    {{ $label }}
</span>
