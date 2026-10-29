<?php

namespace App\Models;

use App\Enums\Dimension;
use Database\Factories\TestResultFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestResult extends Model
{
    /** @use HasFactory<TestResultFactory> */
    use HasFactory;

    protected $fillable = [
        'user_test_id',
        'e_score',
        'i_score',
        's_score',
        'n_score',
        't_score',
        'f_score',
        'j_score',
        'p_score',
        'final_mbti',
        'raw_sums',
        'is_tie',
        'clarity',
        'scoring_version',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'raw_sums' => 'array',
            'is_tie' => 'array',
            'clarity' => 'integer',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<UserTest, $this>
     */
    public function userTest(): BelongsTo
    {
        return $this->belongsTo(UserTest::class);
    }

    /**
     * The profile row for this result's four-letter code.
     *
     * @return BelongsTo<MbtiType, $this>
     */
    public function mbtiType(): BelongsTo
    {
        return $this->belongsTo(MbtiType::class, 'final_mbti', 'code');
    }

    /**
     * Percentage pairs per dimension, keyed by dimension value.
     *
     * @return array<string, array{left: string, right: string, left_score: int, right_score: int, is_tie: bool}>
     */
    public function dimensionBreakdown(): array
    {
        $breakdown = [];

        foreach (Dimension::ordered() as $dimension) {
            $left = $dimension->leftPole();
            $right = $dimension->rightPole();

            $breakdown[$dimension->value] = [
                'left' => $left,
                'right' => $right,
                'left_score' => (int) $this->{$dimension->scoreColumn($left)},
                'right_score' => (int) $this->{$dimension->scoreColumn($right)},
                'is_tie' => (bool) ($this->is_tie[$dimension->value] ?? false),
            ];
        }

        return $breakdown;
    }

    public function scoreFor(string $pole): int
    {
        return (int) $this->{strtolower($pole).'_score'};
    }
}
