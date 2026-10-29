<?php

use App\Enums\SessionStatus;
use App\Models\TestAnswer;
use App\Models\TestResult;
use App\Models\UserTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

function answersFor(UserTest $userTest, int $value = 4): array
{
    return $userTest->answers()
        ->get()
        ->mapWithKeys(fn (TestAnswer $answer): array => [$answer->position => $value])
        ->all();
}

test('the start form renders', function () {
    $this->get(route('test.create'))
        ->assertOk()
        ->assertSee('Nama panggilan')
        ->assertSee('opsional');
});

test('starting a test creates forty answer slots with frozen variants', function () {
    $this->post(route('test.store'), ['name' => 'Dityo', 'age' => 21])
        ->assertRedirect();

    $userTest = UserTest::query()->latest('id')->firstOrFail();

    expect($userTest->status)->toBe(SessionStatus::InProgress)
        ->and($userTest->answers()->count())->toBe(40)
        ->and($userTest->answers()->whereNotNull('question_variant_id')->count())->toBe(40)
        ->and((int) round(abs($userTest->expires_at->diffInHours($userTest->started_at))))->toBe((int) config('mbti.session_ttl_hours'))
        ->and($userTest->token)->toHaveLength(26);
});

test('name is required and age stays optional', function () {
    $this->post(route('test.store'), ['name' => ''])->assertSessionHasErrors('name');

    $this->post(route('test.store'), ['name' => 'Dityo', 'age' => 5])->assertSessionHasErrors('age');

    $this->post(route('test.store'), ['name' => 'Dityo', 'age' => null])->assertRedirect();

    expect(UserTest::query()->count())->toBe(1);
});

test('answers autosave and report progress', function () {
    $userTest = createStartedTest($this);

    $this->patchJson(route('test.answers', $userTest), ['answers' => answersFor($userTest)])
        ->assertOk()
        ->assertJson([
            'answered_count' => 40,
            'total' => 40,
            'progress' => 100,
        ]);
});

test('answering out of range or for a foreign position is rejected', function () {
    $userTest = createStartedTest($this);

    $this->patchJson(route('test.answers', $userTest), ['answers' => [0 => 9]])
        ->assertUnprocessable();

    $this->patchJson(route('test.answers', $userTest), ['answers' => [99 => 3]])
        ->assertUnprocessable();
});

test('submitting a complete test stores the scored result', function () {
    $userTest = createStartedTest($this);

    // Answering against the favoured pole of every item yields INFP.
    $payload = $userTest->answers()
        ->with('question')
        ->get()
        ->mapWithKeys(fn (TestAnswer $answer): array => [
            $answer->position => $answer->question->direction > 0 ? 1 : 5,
        ])
        ->all();

    $this->post(route('test.submit', $userTest), ['answers' => $payload])
        ->assertRedirect(route('result.show', $userTest));

    $userTest->refresh();
    $result = $userTest->result()->firstOrFail();

    expect($userTest->status)->toBe(SessionStatus::Completed)
        ->and($userTest->answered_count)->toBe(40)
        ->and($userTest->completed_at)->not->toBeNull()
        ->and($result->final_mbti)->toBe('INFP')
        ->and($result->i_score)->toBe(100)
        ->and($result->e_score)->toBe(0)
        ->and($result->scoring_version)->toBe(config('mbti.scoring_version'));
});

test('an incomplete submission is refused and creates no result', function () {
    $userTest = createStartedTest($this);

    $partial = array_slice(answersFor($userTest), 0, 12, true);

    $this->post(route('test.submit', $userTest), ['answers' => $partial])
        ->assertSessionHasErrors('answers');

    expect($userTest->refresh()->status)->toBe(SessionStatus::InProgress)
        ->and(TestResult::query()->count())->toBe(0)
        ->and($userTest->answered_count)->toBe(12);
});

test('an expired session rejects writes with 410 and cannot be resumed', function () {
    $userTest = UserTest::factory()->expired()->create();

    $this->patchJson(route('test.answers', $userTest), ['answers' => [0 => 3]])
        ->assertStatus(410);

    $this->get(route('test.show', $userTest))
        ->assertOk()
        ->assertSee('sudah kedaluwarsa');

    expect($userTest->refresh()->status)->toBe(SessionStatus::Expired);
});

test('a completed session redirects back to its result and rejects new answers', function () {
    $userTest = UserTest::factory()->completed()->create();
    TestResult::factory()->for($userTest)->create();

    $this->get(route('test.show', $userTest))
        ->assertRedirect(route('result.show', $userTest));

    $this->patchJson(route('test.answers', $userTest), ['answers' => [0 => 3]])
        ->assertStatus(409);
});

test('result and certificate require a scored attempt', function () {
    $pending = UserTest::factory()->create();

    $this->get(route('result.show', $pending))->assertNotFound();
    $this->get(route('result.certificate', $pending))->assertNotFound();

    $completed = UserTest::factory()->completed()->create();
    TestResult::factory()->for($completed)->create(['final_mbti' => 'INTJ']);

    $this->get(route('result.show', $completed))
        ->assertOk()
        ->assertSee('INTJ')
        ->assertSee($completed->name);

    $this->get(route('result.certificate', $completed))
        ->assertOk()
        ->assertSee('SERTIFIKAT HASIL TES');
});

function createStartedTest(TestCase $case): UserTest
{
    $case->post(route('test.store'), ['name' => 'Dityo'])->assertRedirect();

    return UserTest::query()->latest('id')->firstOrFail();
}
