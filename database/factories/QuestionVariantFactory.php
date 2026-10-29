<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\QuestionVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuestionVariant>
 */
class QuestionVariantFactory extends Factory
{
    protected $model = QuestionVariant::class;

    public function definition(): array
    {
        return [
            'question_id' => Question::factory(),
            'text' => fake()->sentence(12),
            'is_active' => true,
        ];
    }
}
