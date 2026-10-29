<?php

namespace App\Services\Mbti;

use App\Models\UserTest;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class AnswerRecorder
{
    /**
     * Persist a batch of answers for one attempt.
     *
     * The batch is keyed by display position rather than question id so a client
     * can never score a question that was not part of its own attempt.
     *
     * @param  array<int, int>  $values  position => value (1..5)
     */
    public function record(UserTest $userTest, array $values): UserTest
    {
        if ($values === []) {
            return $userTest;
        }

        return DB::transaction(function () use ($userTest, $values): UserTest {
            $answers = $userTest->answers()
                ->whereIn('position', array_keys($values))
                ->get()
                ->keyBy('position');

            foreach ($values as $position => $value) {
                $answer = $answers->get((int) $position);

                if ($answer === null) {
                    throw new InvalidArgumentException("Position {$position} does not belong to this attempt.");
                }

                $answer->forceFill([
                    'value' => (int) $value,
                    'answered_at' => now(),
                ])->save();
            }

            $userTest->forceFill([
                'answered_count' => $userTest->answers()->whereNotNull('value')->count(),
            ])->save();

            return $userTest;
        });
    }

    /**
     * Positions that are still unanswered, in display order.
     *
     * @return array<int, int>
     */
    public function missingPositions(UserTest $userTest): array
    {
        return $userTest->answers()
            ->whereNull('value')
            ->orderBy('position')
            ->pluck('position')
            ->all();
    }
}
