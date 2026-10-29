<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\TestAnswer;
use App\Models\UserTest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TestAnswer>
 */
class TestAnswerFactory extends Factory
{
    protected $model = TestAnswer::class;

    public function definition(): array
    {
        return [
            'user_test_id' => UserTest::factory(),
            'question_id' => Question::factory(),
            'question_variant_id' => null,
            'position' => fake()->numberBetween(0, 39),
            'value' => null,
            'answered_at' => null,
        ];
    }

    public function answered(int $value = 4): static
    {
        return $this->state(fn (): array => [
            'value' => $value,
            'answered_at' => now(),
        ]);
    }
}
