<?php

use App\Enums\TicketStatus;

test('all three status cases exist', function () {
    expect(TicketStatus::cases())->toHaveCount(3);
});

test('from creates status from valid string', function (string $value, TicketStatus $expected) {
    expect(TicketStatus::from($value))->toBe($expected);
})->with([
    ['todo', TicketStatus::Todo],
    ['in_progress', TicketStatus::InProgress],
    ['done', TicketStatus::Done],
]);

test('from throws for invalid string', function () {
    TicketStatus::from('invalid');
})->throws(ValueError::class);
