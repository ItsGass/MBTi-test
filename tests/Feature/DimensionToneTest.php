<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

function srgbToLinear(float $channel): float
{
    return $channel <= 0.03928
        ? $channel / 12.92
        : (($channel + 0.055) / 1.055) ** 2.4;
}

function relativeLuminance(string $hex): float
{
    [$red, $green, $blue] = array_map(
        fn (string $pair): float => srgbToLinear(hexdec($pair) / 255),
        str_split(ltrim($hex, '#'), 2),
    );

    return 0.2126 * $red + 0.7152 * $green + 0.0722 * $blue;
}

function contrastRatio(string $foreground, string $background): float
{
    $first = relativeLuminance($foreground);
    $second = relativeLuminance($background);

    return (max($first, $second) + 0.05) / (min($first, $second) + 0.05);
}

test('every dimension maps to its own pastel tone', function () {
    expect(config('mbti.dimensions.EI.tone'))->toBe('blush')
        ->and(config('mbti.dimensions.SN.tone'))->toBe('sky')
        ->and(config('mbti.dimensions.TF.tone'))->toBe('lilac')
        ->and(config('mbti.dimensions.JP.tone'))->toBe('mint')
        ->and(config('mbti.palette.tones.mint.base'))->toBe('#B5E6D3')
        ->and(config('mbti.palette.tones.mint.soft'))->toBe('#EAF9F3')
        ->and(config('mbti.palette.tones.mint.deep'))->toBe('#86C9AF');
});

test('the landing page paints each dimension label with its tone', function () {
    $response = $this->get(route('home'))->assertOk();
    $html = $response->getContent();

    expect($html)
        ->toContain('bg-blush border-blush-deep/40')
        ->toContain('bg-sky border-sky-deep/40')
        ->toContain('bg-lilac border-lilac-deep/40')
        ->toContain('bg-mint border-mint-deep/40')
        ->toContain('tracking-wider text-ink')
        ->not->toContain('bg-cream-deep text-sm font-semibold tracking-wider text-ink');
});

test('the type catalog reuses the same dimension labels', function () {
    $response = $this->get(route('types.index'))->assertOk();
    $html = $response->getContent();

    expect(substr_count($html, 'h-8 w-12'))->toBe(4)
        ->and($html)->toContain('bg-mint border-mint-deep/40');
});

test('dimension label text keeps AAA contrast on every pastel tone', function () {
    $ink = '#2B2D42';

    foreach (config('mbti.dimensions') as $key => $dimension) {
        $base = config('mbti.palette.tones.'.$dimension['tone'].'.base');

        expect(contrastRatio($ink, $base))
            ->toBeGreaterThanOrEqual(7.0, "Dimension {$key} fails AAA contrast.");
    }
});
