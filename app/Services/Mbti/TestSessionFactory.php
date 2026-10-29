<?php

namespace App\Services\Mbti;

use App\Enums\Dimension;
use App\Enums\SessionStatus;
use App\Models\Question;
use App\Models\TestAnswer;
use App\Models\UserTest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class TestSessionFactory
{
    /**
     * Create a fresh attempt: pick the item pool, freeze one variant per item and
     * interleave dimensions so no single dimension is answered back to back.
     */
    public function create(string $name, ?int $age = null, ?string $ipAddress = null): UserTest
    {
        $perDimension = (int) config('mbti.questions.per_dimension');
        $pool = $this->pool();

        foreach (Dimension::values() as $dimension) {
            if ($pool[$dimension]->count() < $perDimension) {
                throw new RuntimeException(
                    "Dimension {$dimension} only has {$pool[$dimension]->count()} usable questions, {$perDimension} required."
                );
            }
        }

        $selected = collect(Dimension::values())
            ->mapWithKeys(fn (string $dimension): array => [
                $dimension => $pool[$dimension]->shuffle()->take($perDimension)->values(),
            ]);

        $ordered = [];

        for ($index = 0; $index < $perDimension; $index++) {
            foreach (Dimension::values() as $dimension) {
                $ordered[] = $selected[$dimension][$index];
            }
        }

        return DB::transaction(function () use ($ordered, $name, $age, $ipAddress): UserTest {
            $userTest = UserTest::create([
                'name' => $name,
                'age' => $age,
                'status' => SessionStatus::InProgress,
                'total_questions' => count($ordered),
                'answered_count' => 0,
                'started_at' => now(),
                'expires_at' => now()->addHours((int) config('mbti.session_ttl_hours')),
                'ip_address' => $ipAddress,
            ]);

            $rows = [];
            $timestamp = now();

            foreach ($ordered as $position => $question) {
                $rows[] = [
                    'user_test_id' => $userTest->id,
                    'question_id' => $question->id,
                    'question_variant_id' => $question->variants->random()->id,
                    'position' => $position,
                    'value' => null,
                    'answered_at' => null,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }

            TestAnswer::insert($rows);

            return $userTest->load('answers.variant', 'answers.question');
        });
    }

    /**
     * @return array<string, Collection<int, Question>>
     */
    private function pool(): array
    {
        $questions = Question::query()
            ->active()
            ->with(['variants' => fn ($query) => $query->active()])
            ->get()
            ->filter(fn (Question $question): bool => $question->variants->isNotEmpty())
            ->groupBy(fn (Question $question): string => $question->dimension->value);

        return collect(Dimension::values())
            ->mapWithKeys(fn (string $dimension): array => [
                $dimension => $questions->get($dimension, collect())->values(),
            ])
            ->all();
    }
}
