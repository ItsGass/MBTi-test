<?php

use App\Enums\Dimension;
use App\Models\MbtiType;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

test('the instrument contains forty active questions split evenly by dimension', function () {
    expect(Question::query()->active()->count())->toBe(40);

    foreach (Dimension::values() as $dimension) {
        expect(Question::query()->active()->where('dimension', $dimension)->count())->toBe(10);
    }
});

test('every dimension is balanced between positive and negative items', function () {
    foreach (Dimension::values() as $dimension) {
        $positive = Question::query()->active()->where('dimension', $dimension)->where('direction', 1)->count();
        $negative = Question::query()->active()->where('dimension', $dimension)->where('direction', -1)->count();

        expect($positive)->toBe(5)
            ->and($negative)->toBe(5);
    }
});

test('every question offers three active phrasings', function () {
    $questions = Question::query()->active()->with('variants')->get();

    foreach ($questions as $question) {
        expect($question->variants->where('is_active', true))->toHaveCount(3)
            ->and($question->variants->pluck('text')->unique())->toHaveCount(3);
    }
});

test('every type has a complete profile and fifteen compatibility entries', function () {
    $types = MbtiType::query()->get();

    expect($types)->toHaveCount(16);

    foreach ($types as $type) {
        expect($type->code)->toHaveLength(4)
            ->and($type->title)->not->toBeEmpty()
            ->and($type->description)->not->toBeEmpty()
            ->and($type->strengths)->not->toBeEmpty()
            ->and($type->weaknesses)->not->toBeEmpty()
            ->and($type->careers)->not->toBeEmpty()
            ->and($type->compatible_types)->toHaveCount(15)
            ->and($type->accent_color)->toMatch('/^#[0-9A-F]{6}$/i');
    }
});
