@props(['type', 'score' => null, 'index' => null])

@php
    $tone = $type->tonePalette();
    $number = $index !== null ? str_pad((string) $index, 2, '0', STR_PAD_LEFT) : null;
@endphp

<a href="{{ route('types.show', $type) }}"
   class="group surface relative flex flex-col overflow-hidden transition-all duration-500 ease-soft hover:-translate-y-2 hover:border-lilac/60 hover:shadow-lift focus-visible:-translate-y-1">
    <div class="relative flex items-end justify-center overflow-hidden px-4 pt-5"
         style="background: linear-gradient(160deg, {{ $tone['soft'] }} 0%, #FFFFFF 82%);">
        <div class="decor-dots pointer-events-none absolute inset-0 opacity-40" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -top-8 -right-7 h-24 w-24 rounded-full"
             style="background: {{ $tone['base'] }}; opacity: 0.35;" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-6 -left-5 h-16 w-16 rounded-full"
             style="background: {{ $tone['base'] }}; opacity: 0.22;" aria-hidden="true"></div>

        @if ($number)
            <span class="absolute top-3 left-4 text-[0.65rem] font-semibold tracking-[0.22em]"
                  style="color: {{ $tone['deep'] }};">
                {{ $number }}
            </span>
        @endif

        <x-chibi :type="$type" :size="132" />
    </div>

    <div class="flex flex-1 flex-col px-5 pt-4 pb-5">
        <div class="flex items-start justify-between gap-2">
            <div class="min-w-0">
                <h3 class="heading-md leading-tight">{{ $type->title }}</h3>
                <p class="mt-1 truncate text-[0.65rem] font-medium tracking-[0.16em] text-ink-muted uppercase">
                    {{ $type->alias }}
                </p>
            </div>

            <div class="flex shrink-0 flex-col items-end gap-1.5">
                <span class="text-sm font-bold tracking-[0.18em]" style="color: {{ $tone['deep'] }};">
                    {{ $type->code }}
                </span>
                @if ($score !== null)
                    <span class="chip-ink text-[0.65rem]">{{ $score }}%</span>
                @endif
            </div>
        </div>

        <span class="mt-auto inline-flex items-center gap-1 pt-4 text-xs font-medium text-ink-muted transition-colors duration-300 group-hover:text-ink">
            Lihat profil
            <svg class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                <path d="M3 8h9M8 4l4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
    </div>
</a>
