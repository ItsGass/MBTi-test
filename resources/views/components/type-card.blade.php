@props(['type', 'score' => null])

<a href="{{ route('types.show', $type) }}"
   class="group surface relative flex flex-col gap-3 p-5 transition-all duration-300 ease-soft hover:-translate-y-1 hover:border-lilac/50 hover:shadow-lift">
    <div class="flex items-start justify-between gap-2">
        <span class="text-sm font-bold tracking-[0.2em]" style="color: {{ $type->accent_color }}">{{ $type->code }}</span>
        @if ($score !== null)
            <span class="chip-lilac">{{ $score }}%</span>
        @endif
    </div>

    <div>
        <h3 class="heading-md leading-tight">{{ $type->title }}</h3>
        <p class="mt-1 text-[0.7rem] font-medium tracking-[0.16em] text-ink-muted uppercase">{{ $type->alias }}</p>
    </div>

    <span class="mt-auto inline-flex items-center gap-1 text-xs font-medium text-ink-muted transition-colors duration-200 group-hover:text-ink">
        Lihat profil
        <svg class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-0.5" viewBox="0 0 16 16" fill="none" aria-hidden="true">
            <path d="M3 8h9M8 4l4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </span>
</a>
