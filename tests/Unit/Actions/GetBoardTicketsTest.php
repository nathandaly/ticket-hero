<?php

use App\Actions\Board\GetBoardTickets;
use App\Enums\TicketStatus;
use App\Models\Ticket;

test('returns tickets grouped by status', function () {
    Ticket::factory()->count(2)->create(['status' => TicketStatus::Todo]);
    Ticket::factory()->count(1)->create(['status' => TicketStatus::InProgress]);
    Ticket::factory()->count(3)->create(['status' => TicketStatus::Done]);

    $result = app(GetBoardTickets::class)->handle();

    expect($result['todo'])->toHaveCount(2)
        ->and($result['in_progress'])->toHaveCount(1)
        ->and($result['done'])->toHaveCount(3);
});

test('empty board returns empty arrays', function () {
    $result = app(GetBoardTickets::class)->handle();

    expect($result['todo'])->toBeEmpty()
        ->and($result['in_progress'])->toBeEmpty()
        ->and($result['done'])->toBeEmpty();
});

test('tickets include hero relationship', function () {
    Ticket::factory()->create(['status' => TicketStatus::Todo]);

    $result = app(GetBoardTickets::class)->handle();

    expect($result['todo']->first()->relationLoaded('hero'))->toBeTrue()
        ->and($result['todo']->first()->hero)->not->toBeNull();
});
