<?php

namespace Database\Factories;

use App\Models\TestResult;
use App\Models\UserTest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TestResult>
 */
class TestResultFactory extends Factory
{
    protected $model = TestResult::class;

    public function definition(): array
    {
        return [
            'user_test_id' => UserTest::factory()->completed(),
            'e_score' => 62,
            'i_score' => 38,
            's_score' => 45,
            'n_score' => 55,
            't_score' => 70,
            'f_score' => 30,
            'j_score' => 58,
            'p_score' => 42,
            'final_mbti' => 'INTJ',
            'raw_sums' => ['EI' => -6, 'SN' => 3, 'TF' => 10, 'JP' => 4],
            'is_tie' => ['EI' => false, 'SN' => false, 'TF' => false, 'JP' => false],
            'clarity' => 42,
            'scoring_version' => 'v1',
            'completed_at' => now(),
        ];
    }
}
