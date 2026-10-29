<?php

namespace App\Services\Mbti;

use App\Models\MbtiType;
use Illuminate\Support\Collection;

class CompatibilityMatcher
{
    /**
     * @return Collection<int, MbtiType>
     */
    public function allTypes(): Collection
    {
        return MbtiType::query()->orderBy('code')->get();
    }

    public function type(string $code): MbtiType
    {
        return MbtiType::query()->where('code', strtoupper($code))->firstOrFail();
    }

    /**
     * Resolve a pairing regardless of argument order.
     *
     * @return array{
     *     type_a: MbtiType,
     *     type_b: MbtiType,
     *     score: int,
     *     label: string,
     *     note: string,
     *     tone: string
     * }
     */
    public function pair(string $left, string $right): array
    {
        $typeA = $this->type($left);
        $typeB = $this->type($right);

        // The matrix is symmetric, so reading from either side is valid. Read from
        // the alphabetically first type to keep the output deterministic.
        $source = strcmp($typeA->code, $typeB->code) <= 0 ? $typeA : $typeB;
        $target = $source->is($typeA) ? $typeB : $typeA;

        $entry = $source->compatibilityWith($target->code);

        $score = (int) ($entry['score'] ?? 50);
        $band = $this->bandFor($score);

        return [
            'type_a' => $typeA,
            'type_b' => $typeB,
            'score' => $score,
            'label' => $entry['label'] ?? $band['label'],
            'note' => $entry['note'] ?? '',
            'tone' => $band['tone'],
        ];
    }

    /**
     * @return array{label: string, tone: string}
     */
    public function bandFor(int $score): array
    {
        foreach (config('mbti.compatibility.bands') as $band) {
            if ($score >= $band['min']) {
                return ['label' => $band['label'], 'tone' => $band['tone']];
            }
        }

        return ['label' => 'Tantangan', 'tone' => 'slate'];
    }

    /**
     * @return Collection<int, array{code: string, title: string, alias: string, score: int, label: string, note: string}>
     */
    public function bestMatches(string $code, ?int $limit = null): Collection
    {
        $type = $this->type($code);
        $limit ??= (int) config('mbti.compatibility.recommendations');

        return $type->bestMatches($limit)
            ->map(fn (array $entry): array => [
                ...$entry,
                'title' => $this->type($entry['code'])->title,
                'alias' => $this->type($entry['code'])->alias,
            ]);
    }

    /**
     * Shared and differing dimensions, used to explain a pairing in the UI.
     *
     * @return array{shared: array<int, string>, different: array<int, string>}
     */
    public function dimensionOverlap(string $left, string $right): array
    {
        $shared = [];
        $different = [];

        foreach (str_split(strtoupper($left)) as $index => $letter) {
            $other = strtoupper($right)[$index];

            if ($letter === $other) {
                $shared[] = $letter;
            } else {
                $different[] = $letter.'/'.$other;
            }
        }

        return ['shared' => $shared, 'different' => $different];
    }
}
