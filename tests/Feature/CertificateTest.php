<?php

use App\Models\MbtiType;
use App\Models\TestResult;
use App\Models\UserTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

function completedResult(string $code = 'INTJ', ?int $age = 27, string $name = 'Dityo Pratama'): UserTest
{
    $userTest = UserTest::factory()->completed()->create(['name' => $name, 'age' => $age]);

    TestResult::factory()->for($userTest)->create(['final_mbti' => $code]);

    return $userTest;
}

test('the certificate renders in landscape with every required section', function () {
    $userTest = completedResult();

    $response = $this->get(route('result.certificate', $userTest))->assertOk();

    $response->assertSee('SERTIFIKAT HASIL TES')
        ->assertSee('DIBERIKAN KEPADA')
        ->assertSee('EMPAT DIMENSI')
        ->assertSee('REKOMENDASI KARIER')
        ->assertSee('PALING COCOK')
        ->assertSee('Dityo Pratama')
        ->assertSee('Usia 27 tahun')
        ->assertSee('INTJ')
        ->assertSee('width:1200px', false)
        ->assertSee('height:850px', false)
        ->assertSee('data-width="1200"', false)
        ->assertSee('data-height="850"', false)
        ->assertSee('data-scale="2"', false);

    expect($response->viewData('matches'))->toHaveCount(3)
        ->and($response->viewData('careers'))->toHaveCount(4);
});

test('the certificate prints the user name age dimensions careers and matches', function () {
    $userTest = completedResult();
    $type = MbtiType::query()->where('code', 'INTJ')->firstOrFail();
    $best = $type->bestMatches(3)->first();

    $this->get(route('result.certificate', $userTest))
        ->assertOk()
        ->assertSee(Str::limit($type->careers[0], (int) config('mbti.certificate.career_limit')))
        ->assertSee($best['code'])
        ->assertSee($best['score'].'%')
        ->assertSee('E '.$userTest->result->e_score.'%', false)
        ->assertSee('I '.$userTest->result->i_score.'%', false);
});

test('an empty age leaves the identity block stable', function () {
    $userTest = completedResult(age: null);

    $this->get(route('result.certificate', $userTest))
        ->assertOk()
        ->assertSee('Usia tidak diisi');
});

test('the certificate exposes its chibi illustration', function () {
    $userTest = completedResult();

    $this->get(route('result.certificate', $userTest))
        ->assertOk()
        ->assertSee('viewBox="0 0 120 120"', false)
        ->assertSee('aspect-ratio:1 / 1', false);
});

test('the certificate keeps its text boxes unclipped for html2canvas', function () {
    $userTest = completedResult();

    $html = $this->get(route('result.certificate', $userTest))->assertOk()->getContent();

    expect($html)->not->toContain('nowrap;overflow:hidden')
        ->not->toContain('color:#2B2D42;overflow:hidden');
});

test('the type catalog renders sixteen unique chibis', function () {
    $response = $this->get(route('types.index'))->assertOk();
    $html = $response->getContent();

    $props = collect(config('mbti.chibi.types'))->pluck('prop');

    expect(substr_count($html, 'viewBox="0 0 120 120"'))->toBe(16)
        ->and($props)->toHaveCount(16)
        ->and($props->unique())->toHaveCount(16)
        ->and($props->every(fn (string $prop): bool => $prop !== ''))->toBeTrue();
});

test('a type profile labels its chibi for assistive technology', function () {
    $this->get(route('types.show', 'INTJ'))
        ->assertOk()
        ->assertSee('Ilustrasi chibi INTJ Arsitek');
});

test('the certificate dimension bars follow the site palette', function () {
    $userTest = completedResult();

    $this->get(route('result.certificate', $userTest))
        ->assertOk()
        ->assertSee('background:#FFC8DD;"', false)
        ->assertSee('background:#A2D2FF;"', false)
        ->assertSee('background:#CDB4DB;"', false)
        ->assertSee('background:#B5E6D3;"', false);
});

test('the palette and certificate dimensions are centralised in config', function () {
    expect(config('mbti.palette.cream'))->toBe('#FFF9F5')
        ->and(config('mbti.palette.ink'))->toBe('#2B2D42')
        ->and(config('mbti.palette.tones.lilac.base'))->toBe('#CDB4DB')
        ->and(config('mbti.palette.tones.blush.base'))->toBe('#FFC8DD')
        ->and(config('mbti.palette.tones.sky.base'))->toBe('#A2D2FF')
        ->and(config('mbti.palette.tones.mint.base'))->toBe('#B5E6D3')
        ->and(config('mbti.certificate.width'))->toBe(1200)
        ->and(config('mbti.certificate.height'))->toBe(850);
});
