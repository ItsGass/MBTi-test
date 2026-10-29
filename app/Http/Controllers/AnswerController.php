<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAnswersRequest;
use App\Models\UserTest;
use App\Services\Mbti\AnswerRecorder;
use Illuminate\Http\JsonResponse;

class AnswerController extends Controller
{
    public function update(UpdateAnswersRequest $request, UserTest $userTest, AnswerRecorder $recorder): JsonResponse
    {
        $userTest = $recorder->record($userTest, $request->values());

        return response()->json([
            'answered_count' => $userTest->answered_count,
            'total' => $userTest->total_questions,
            'progress' => $userTest->progressPercent(),
            'saved_at' => now()->toIso8601String(),
        ]);
    }
}
