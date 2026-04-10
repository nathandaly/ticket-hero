<?php

use App\Enums\Difficulty;

test('all five difficulty cases exist', function () {
    expect(Difficulty::cases())->toHaveCount(5);
});

test('each difficulty returns correct xp', function (Difficulty $difficulty, int $expectedXp) {
    expect($difficulty->xp())->toBe($expectedXp);
})->with([
    [Difficulty::Easy, 10],
    [Difficulty::Medium, 20],
    [Difficulty::Hard, 30],
    [Difficulty::Expert, 40],
    [Difficulty::Legendary, 50],
]);

test('from creates difficulty from valid integer', function () {
    expect(Difficulty::from(3))->toBe(Difficulty::Hard);
});

test('from throws for invalid integer', function () {
    Difficulty::from(6);
})->throws(ValueError::class);
