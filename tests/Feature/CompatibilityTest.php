<?php

use App\Models\MbtiType;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

test('a pairing reads the same in either order', function () {
    $forward = $this->get(route('compatibility.show', ['INTJ', 'ENFP']))->assertOk();
    $backward = $this->get(route('compatibility.show', ['ENFP', 'INTJ']))->assertOk();

    $forwardScore = $forward->viewData('pair')['score'];
    $backwardScore = $backward->viewData('pair')['score'];

    expect($forwardScore)->toBe($backwardScore)
        ->and($forwardScore)->toBeGreaterThan(0);
});

test('an unknown type code returns not found', function () {
    $this->get(route('compatibility.show', ['INTJ', 'ZZZZ']))->assertNotFound();
});

test('the matrix is symmetric for every pair', function () {
    $types = MbtiType::query()->get();

    expect($types)->toHaveCount(16);

    foreach ($types as $type) {
        expect($type->compatible_types)->toHaveCount(15);

        foreach ($type->compatible_types as $entry) {
            $mirror = MbtiType::query()->where('code', $entry['code'])->firstOrFail();
            $reverse = collect($mirror->compatible_types)->firstWhere('code', $type->code);

            expect($reverse)->not->toBeNull()
                ->and($reverse['score'])->toBe($entry['score']);
        }
    }
});

test('the compatibility index accepts a preselected pair and redirects', function () {
    $this->get(route('compatibility.index', ['a' => 'INFJ', 'b' => 'ENFP']))
        ->assertRedirect(route('compatibility.show', ['INFJ', 'ENFP']));
});

test('the best matches for a result are ordered by score', function () {
    $matches = MbtiType::query()->where('code', 'INTJ')->firstOrFail()->bestMatches(3);

    expect($matches)->toHaveCount(3)
        ->and($matches->pluck('score')->all())->toBe(
            $matches->pluck('score')->sortDesc()->values()->all()
        );
});
