<?php

namespace App\Http\Controllers;

use App\Enums\SessionStatus;
use App\Http\Requests\StoreTestSessionRequest;
use App\Http\Requests\UpdateAnswersRequest;
use App\Models\TestAnswer;
use App\Models\UserTest;
use App\Services\Mbti\AnswerRecorder;
use App\Services\Mbti\MbtiScorer;
use App\Services\Mbti\TestSessionFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TestSessionController extends Controller
{
    public function create(): View
    {
        return view('pages.test.start');
    }

    public function store(StoreTestSessionRequest $request, TestSessionFactory $factory): RedirectResponse
    {
        $validated = $request->validated();

        $userTest = $factory->create(
            name: $validated['name'],
            age: isset($validated['age']) ? (int) $validated['age'] : null,
            ipAddress: $request->ip(),
        );

        $request->session()->put('mbti.last_token', $userTest->token);

        return redirect()
            ->route('test.show', $userTest)
            ->with('status', 'Tes dimulai. Jawab dengan spontan, tidak ada jawaban benar atau salah.');
    }

    public function show(Request $request, UserTest $userTest): View|RedirectResponse
    {
        if ($userTest->isCompleted()) {
            return redirect()->route('result.show', $userTest);
        }

        if ($userTest->hasExpired()) {
            if ($userTest->status !== SessionStatus::Expired) {
                $userTest->update(['status' => SessionStatus::Expired]);
            }

            return view('pages.test.expired', ['userTest' => $userTest]);
        }

        $answers = $userTest->answers()
            ->with(['question', 'variant'])
            ->get();

        $perPage = (int) config('mbti.questions.per_page');
        $pages = $answers->chunk($perPage)->values();

        $firstUnanswered = $answers->search(fn (TestAnswer $answer): bool => $answer->value === null);
        $requestedPage = (int) $request->query('halaman', 0);
        $defaultPage = $firstUnanswered === false
            ? $pages->count()
            : intdiv((int) $firstUnanswered, $perPage) + 1;

        $activePage = max(1, min($pages->count(), $requestedPage ?: $defaultPage));

        return view('pages.test.show', [
            'userTest' => $userTest,
            'pages' => $pages,
            'activePage' => $activePage,
            'perPage' => $perPage,
            'missing' => $answers->whereNull('value')->count(),
        ]);
    }

    public function submit(UpdateAnswersRequest $request, UserTest $userTest, AnswerRecorder $recorder, MbtiScorer $scorer): RedirectResponse
    {
        if ($userTest->hasExpired()) {
            $userTest->update(['status' => SessionStatus::Expired]);

            return redirect()->route('test.show', $userTest);
        }

        if (! $userTest->isInProgress()) {
            return redirect()->route('result.show', $userTest);
        }

        // The form posts every selected radio, so a no-JS submit still records answers.
        $recorder->record($userTest, $request->values());

        $missing = $recorder->missingPositions($userTest);

        if ($missing !== []) {
            return redirect()
                ->route('test.show', ['userTest' => $userTest, 'halaman' => intdiv($missing[0], (int) config('mbti.questions.per_page')) + 1])
                ->withErrors([
                    'answers' => sprintf(
                        'Masih ada %d pernyataan yang belum dijawab. Mulai dari nomor %d.',
                        count($missing),
                        (int) $missing[0] + 1,
                    ),
                ]);
        }

        DB::transaction(function () use ($userTest, $scorer): void {
            $scorer->scoreTest($userTest);

            $userTest->update([
                'status' => SessionStatus::Completed,
                'answered_count' => $userTest->answers()->whereNotNull('value')->count(),
                'completed_at' => now(),
            ]);
        });

        return redirect()->route('result.show', $userTest);
    }
}
