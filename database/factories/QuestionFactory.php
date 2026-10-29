<?php

namespace Database\Factories;

use App\Enums\Dimension;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'dimension' => Dimension::EI,
            'direction' => 1,
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }

    public function direction(int $direction): static
    {
        return $this->state(fn (): array => ['direction' => $direction]);
    }

    public function dimension(Dimension $dimension): static
    {
        return $this->state(fn (): array => ['dimension' => $dimension]);
    }

    public function inactive(): static
    {
        return $this->state(fn (): array => ['is_active' => false]);
    }
}
