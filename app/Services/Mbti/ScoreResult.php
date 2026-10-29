<?php

namespace App\Services\Mbti;

use App\Enums\Dimension;

/**
 * Immutable outcome of a scored attempt.
 */
final readonly class ScoreResult
{
    /**
     * @param  array<string, int>  $percentages  pole letter => 0..100, every pair sums to 100
     * @param  array<string, int>  $rawSums  dimension value => -20..20
     * @param  array<string, bool>  $ties  dimension value => whether the raw sum was exactly zero
     */
    public function __construct(
        public string $type,
        public array $percentages,
        public array $rawSums,
        public array $ties,
        public int $clarity,
        public bool $tieBreakerApplied,
    ) {}

    public function scoreFor(string $pole): int
    {
        return $this->percentages[strtoupper($pole)] ?? 0;
    }

    /**
     * @return array<string, array{left: string, right: string, left_score: int, right_score: int, is_tie: bool}>
     */
    public function breakdown(): array
    {
        $breakdown = [];

        foreach (Dimension::ordered() as $dimension) {
            $left = $dimension->leftPole();
            $right = $dimension->rightPole();

            $breakdown[$dimension->value] = [
                'left' => $left,
                'right' => $right,
                'left_score' => $this->scoreFor($left),
                'right_score' => $this->scoreFor($right),
                'is_tie' => $this->ties[$dimension->value] ?? false,
            ];
        }

        return $breakdown;
    }

    /**
     * Column => value payload for the test_results table.
     *
     * @return array<string, mixed>
     */
    public function toResultAttributes(): array
    {
        $attributes = [];

        foreach ($this->percentages as $pole => $score) {
            $attributes[strtolower($pole).'_score'] = $score;
        }

        return [
            ...$attributes,
            'final_mbti' => $this->type,
            'raw_sums' => $this->rawSums,
            'is_tie' => $this->ties,
            'clarity' => $this->clarity,
            'scoring_version' => config('mbti.scoring_version'),
        ];
    }
}
