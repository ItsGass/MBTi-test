<?php

namespace Database\Factories;

use App\Enums\SessionStatus;
use App\Models\UserTest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<UserTest>
 */
class UserTestFactory extends Factory
{
    protected $model = UserTest::class;

    public function definition(): array
    {
        return [
            'token' => (string) Str::ulid(),
            'name' => fake()->firstName(),
            'age' => fake()->numberBetween(18, 40),
            'status' => SessionStatus::InProgress,
            'total_questions' => 40,
            'answered_count' => 0,
            'started_at' => now(),
            'expires_at' => now()->addHours(24),
            'completed_at' => null,
            'ip_address' => '127.0.0.1',
        ];
    }

    public function expired(): static
    {
        return $this->state(fn (): array => [
            'status' => SessionStatus::InProgress,
            'started_at' => now()->subHours(30),
            'expires_at' => now()->subHours(6),
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (): array => [
            'status' => SessionStatus::Completed,
            'completed_at' => now(),
            'answered_count' => 40,
        ]);
    }
}
