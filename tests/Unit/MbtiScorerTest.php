<?php

use App\Services\Mbti\MbtiScorer;

/**
 * @param  array<int, array{dimension: string, direction: int, value: int|null}>  $items
 */
function extremeItems(int $positiveValue, int $negativeValue): array
{
    $items = [];

    foreach (['EI', 'SN', 'TF', 'JP'] as $dimension) {
        for ($index = 0; $index < 5; $index++) {
            $items[] = ['dimension' => $dimension, 'direction' => 1, 'value' => $positiveValue];
            $items[] = ['dimension' => $dimension, 'direction' => -1, 'value' => $negativeValue];
        }
    }

    return $items;
}

test('maximally agreeing answers resolve to the left poles', function () {
    $result = (new MbtiScorer)->score(extremeItems(5, 1));

    expect($result->type)->toBe('ESTJ')
        ->and($result->scoreFor('E'))->toBe(100)
        ->and($result->scoreFor('I'))->toBe(0)
        ->and($result->clarity)->toBe(100)
        ->and($result->tieBreakerApplied)->toBeFalse();
});

test('maximally disagreeing answers resolve to the right poles', function () {
    $result = (new MbtiScorer)->score(extremeItems(1, 5));

    expect($result->type)->toBe('INFP')
        ->and($result->scoreFor('P'))->toBe(100)
        ->and($result->scoreFor('J'))->toBe(0);
});

test('neutral answers produce a perfect split on every dimension', function () {
    $result = (new MbtiScorer)->score(extremeItems(3, 3));

    expect(array_values($result->ties))->each->toBeTrue()
        ->and($result->scoreFor('E'))->toBe(50)
        ->and($result->scoreFor('I'))->toBe(50)
        ->and($result->clarity)->toBe(0);
});

test('balanced direction prevents agreement from tilting a dimension', function () {
    // Five positive and five negative items per dimension means answering "5"
    // everywhere cancels out instead of pushing every dimension to one pole.
    $result = (new MbtiScorer)->score(extremeItems(5, 5));

    expect(array_values($result->ties))->each->toBeTrue()
        ->and($result->scoreFor('E'))->toBe(50)
        ->and($result->scoreFor('S'))->toBe(50)
        ->and($result->scoreFor('T'))->toBe(50)
        ->and($result->scoreFor('J'))->toBe(50);
});

test('a tie is broken by the pole with more extreme answers', function () {
    $items = [
        ['dimension' => 'EI', 'direction' => 1, 'value' => 5],
        ['dimension' => 'EI', 'direction' => 1, 'value' => 2],
        ['dimension' => 'EI', 'direction' => -1, 'value' => 4],
        ['dimension' => 'EI', 'direction' => -1, 'value' => 3],
    ];

    $result = (new MbtiScorer)->score($items);

    expect($result->rawSums['EI'])->toBe(0)
        ->and($result->ties['EI'])->toBeTrue()
        ->and($result->type[0])->toBe('E');
});

test('an evenly strong tie falls back to the configured left pole', function () {
    $items = [
        ['dimension' => 'EI', 'direction' => 1, 'value' => 5],
        ['dimension' => 'EI', 'direction' => 1, 'value' => 1],
    ];

    $result = (new MbtiScorer)->score($items);

    expect($result->rawSums['EI'])->toBe(0)
        ->and($result->type[0])->toBe('E')
        ->and($result->percentages['E'])->toBe(50);
});

test('unanswered items are ignored rather than counted as neutral', function () {
    $items = [
        ['dimension' => 'TF', 'direction' => 1, 'value' => 5],
        ['dimension' => 'TF', 'direction' => 1, 'value' => null],
        ['dimension' => 'TF', 'direction' => -1, 'value' => null],
    ];

    $result = (new MbtiScorer)->score($items);

    expect($result->rawSums['TF'])->toBe(2)
        ->and($result->scoreFor('T'))->toBe(55);
});
