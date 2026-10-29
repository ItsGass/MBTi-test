<?php

namespace App\Services\Mbti;

use App\Enums\Dimension;
use App\Models\TestAnswer;
use App\Models\TestResult;
use App\Models\UserTest;

class MbtiScorer
{
    /**
     * Score a full set of answers.
     *
     * Each item contributes `direction * (value - 3)` points to the left pole of
     * its dimension. With ten items per dimension the raw sum lands in -20..20,
     * which maps linearly onto a 0..100 percentage for the left pole.
     *
     * @param  iterable<int, TestAnswer|array{dimension: string|Dimension, direction: int, value: int|null}>  $items
     */
    public function score(iterable $items): ScoreResult
    {
        $rawSums = [];
        $strongLeft = [];
        $strongRight = [];

        foreach (Dimension::values() as $dimension) {
            $rawSums[$dimension] = 0;
            $strongLeft[$dimension] = 0;
            $strongRight[$dimension] = 0;
        }

        foreach ($items as $item) {
            $dimension = $item instanceof TestAnswer
                ? $item->question->dimension
                : Dimension::from(is_string($item['dimension']) ? $item['dimension'] : $item['dimension']->value);

            $direction = (int) ($item instanceof TestAnswer ? $item->question->direction : $item['direction']);
            $value = $item instanceof TestAnswer ? $item->value : $item['value'];

            if ($value === null) {
                continue;
            }

            $value = (int) $value;
            $offset = $value - (int) config('mbti.likert.neutral');

            $rawSums[$dimension->value] += $direction * $offset;

            // A "strong" answer is the extreme end of the scale pointing at a pole.
            if ($value === (int) config('mbti.likert.max')) {
                $direction > 0 ? $strongLeft[$dimension->value]++ : $strongRight[$dimension->value]++;
            } elseif ($value === (int) config('mbti.likert.min')) {
                $direction > 0 ? $strongRight[$dimension->value]++ : $strongLeft[$dimension->value]++;
            }
        }

        return $this->buildResult($rawSums, $strongLeft, $strongRight);
    }

    /**
     * Score a persisted attempt and refresh its stored result row.
     */
    public function scoreTest(UserTest $userTest): TestResult
    {
        $userTest->loadMissing(['answers.question']);

        $result = $this->score($userTest->answers);

        return $userTest->result()->updateOrCreate([], [
            ...$result->toResultAttributes(),
            'completed_at' => now(),
        ]);
    }

    /**
     * @param  array<string, int>  $rawSums
     * @param  array<string, int>  $strongLeft
     * @param  array<string, int>  $strongRight
     */
    private function buildResult(array $rawSums, array $strongLeft, array $strongRight): ScoreResult
    {
        $maxRaw = (int) config('mbti.questions.per_dimension')
            * ((int) config('mbti.likert.max') - (int) config('mbti.likert.neutral'));

        $type = '';
        $deviation = 0;
        $percentages = [];
        $ties = [];
        $tieBreakerApplied = false;

        foreach (Dimension::ordered() as $dimension) {
            $key = $dimension->value;
            $raw = $rawSums[$key];
            $left = $dimension->leftPole();
            $right = $dimension->rightPole();

            // raw sum -maxRaw..maxRaw => left percentage 0..100
            $leftScore = (int) round(50 + ($raw / $maxRaw) * 50);
            $leftScore = max(0, min(100, $leftScore));

            $percentages[$left] = $leftScore;
            $percentages[$right] = 100 - $leftScore;
            $deviation += abs($leftScore - 50) * 2;

            if ($raw === 0) {
                $ties[$key] = true;
                $tieBreakerApplied = true;
                $pole = $this->breakTie($strongLeft[$key], $strongRight[$key], $left, $right);
            } else {
                $ties[$key] = false;
                $pole = $raw > 0 ? $left : $right;
            }

            $type .= $pole;
        }

        $clarity = (int) round($deviation / count(Dimension::ordered()));

        return new ScoreResult(
            type: $type,
            percentages: $percentages,
            rawSums: $rawSums,
            ties: $ties,
            clarity: $clarity,
            tieBreakerApplied: $tieBreakerApplied,
        );
    }

    /**
     * When a dimension is split exactly down the middle, the side with more
     * extreme answers is considered more convincing. A perfectly symmetric
     * response pattern falls back to the configured default pole.
     */
    private function breakTie(int $strongLeft, int $strongRight, string $left, string $right): string
    {
        if ($strongLeft === $strongRight) {
            return config('mbti.tie_break.default_pole') === 'right' ? $right : $left;
        }

        return $strongLeft > $strongRight ? $left : $right;
    }
}
