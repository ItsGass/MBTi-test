@props(['answer'])

@php
    $position = $answer->position;
    $likert = config('mbti.likert');
@endphp

<fieldset class="surface p-5 sm:p-6" data-answer-fieldset data-position="{{ $position }}">
    <legend class="sr-only">Pernyataan nomor {{ $position + 1 }}</legend>

    <div class="flex items-start gap-4">
        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-2xl bg-cream-deep text-xs font-semibold text-ink-soft">
            {{ str_pad((string) ($position + 1), 2, '0', STR_PAD_LEFT) }}
        </span>
        <p class="pt-1.5 text-[0.95rem] leading-relaxed font-medium text-ink">
            {{ $answer->variant?->text ?? $answer->question->variants->first()?->text }}
        </p>
    </div>

    <div class="mt-5 grid grid-cols-5 gap-2" role="radiogroup" aria-label="Pilih tingkat kesetujuan">
        @foreach ($likert['labels'] as $value => $label)
            <label class="group cursor-pointer">
                <input
                    type="radio"
                    name="answers[{{ $position }}]"
                    value="{{ $value }}"
                    class="peer sr-only"
                    @checked($answer->value === $value)
                >
                <span class="flex h-full flex-col items-center justify-center gap-1 rounded-2xl border border-line bg-white/70 px-1.5 py-3 text-center transition-all duration-200 ease-soft group-hover:-translate-y-0.5 group-hover:border-lilac/60 peer-checked:border-lilac peer-checked:bg-lilac-soft peer-checked:shadow-soft peer-focus-visible:ring-2 peer-focus-visible:ring-lilac peer-focus-visible:ring-offset-2">
                    <span class="text-sm font-semibold text-ink">{{ $likert['short_labels'][$value] }}</span>
                    <span class="hidden text-[0.6rem] leading-tight text-ink-muted sm:block">{{ $label }}</span>
                </span>
            </label>
        @endforeach
    </div>
</fieldset>
