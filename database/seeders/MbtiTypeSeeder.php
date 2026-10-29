<?php

namespace Database\Seeders;

use App\Enums\Dimension;
use App\Models\MbtiType;
use Illuminate\Database\Seeder;

class MbtiTypeSeeder extends Seeder
{
    /**
     * Titles from the reference dataset were partly mistranslated; these are the
     * names used consistently across the site.
     *
     * @var array<string, string>
     */
    private array $titleFixes = [
        'ENFP' => 'Juru Kampanye',
        'ESFP' => 'Penghibur',
        'INFP' => 'Pendamai',
        'ISFP' => 'Petualang',
    ];

    public function run(): void
    {
        $catalog = require database_path('seeders/data/mbti_catalog.php');

        $matrix = $this->matrix($catalog['pairs']);

        foreach ($catalog['types'] as $code => $type) {
            $compatible = collect($matrix[$code] ?? [])
                ->reject(fn (int $score, string $other): bool => $other === $code)
                ->map(fn (int $score, string $other): array => [
                    'code' => $other,
                    'score' => $score,
                    'label' => $this->bandLabel($score),
                    'note' => $this->noteFor($code, $other),
                ])
                ->sortByDesc('score')
                ->values()
                ->all();

            MbtiType::updateOrCreate(
                ['code' => $code],
                [
                    'title' => $this->titleFixes[$code] ?? $type['title'],
                    'alias' => $type['alias'],
                    'description' => $type['description'],
                    'strengths' => $type['strengths'],
                    'weaknesses' => $type['weaknesses'],
                    'careers' => $type['careers'],
                    'compatible_types' => $compatible,
                    'accent_color' => $type['accent_color'],
                ]
            );
        }
    }

    /**
     * Build a symmetric lookup: both A->B and B->A carry the same score.
     *
     * @param  array<int, array{0: string, 1: string, 2: int}>  $pairs
     * @return array<string, array<string, int>>
     */
    private function matrix(array $pairs): array
    {
        $matrix = [];

        foreach ($pairs as [$left, $right, $score]) {
            $matrix[$left][$right] = (int) $score;
            $matrix[$right][$left] = (int) $score;
        }

        return $matrix;
    }

    private function bandLabel(int $score): string
    {
        foreach (config('mbti.compatibility.bands') as $band) {
            if ($score >= $band['min']) {
                return $band['label'];
            }
        }

        return 'Tantangan';
    }

    /**
     * Explain a pairing from the dimensions the two types share.
     */
    private function noteFor(string $left, string $right): string
    {
        $shared = [];

        foreach (Dimension::ordered() as $index => $dimension) {
            if ($left[$index] === $right[$index]) {
                $shared[] = $left[$index];
            }
        }

        return match (count($shared)) {
            4 => 'Tipe yang sama, jadi ritme dan cara berpikir kalian sangat mirip.',
            3 => 'Sama di tiga dari empat dimensi, sehingga cara pandang kalian mudah bertemu.',
            2 => 'Seimbang: dua dimensi sama dan dua saling melengkapi.',
            1 => 'Banyak perbedaan yang bisa saling melengkapi selama komunikasi dijaga.',
            default => 'Semua dimensi berbeda, butuh usaha ekstra untuk saling memahami.',
        };
    }
}
