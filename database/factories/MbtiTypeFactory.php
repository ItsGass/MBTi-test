<?php

namespace Database\Factories;

use App\Models\MbtiType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MbtiType>
 */
class MbtiTypeFactory extends Factory
{
    protected $model = MbtiType::class;

    public function definition(): array
    {
        $code = fake()->randomElement(['INTJ', 'ENFP', 'ISTJ', 'ESFJ']);

        return [
            'code' => $code,
            'title' => fake()->words(2, true),
            'alias' => 'The '.fake()->word(),
            'description' => fake()->paragraph(),
            'strengths' => [fake()->sentence(4), fake()->sentence(4)],
            'weaknesses' => [fake()->sentence(4)],
            'careers' => [fake()->jobTitle(), fake()->jobTitle()],
            'compatible_types' => [],
            'accent_color' => '#A78BFA',
        ];
    }
}
