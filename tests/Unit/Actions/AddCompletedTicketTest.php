<?php

use App\Actions\Tickets\AddCompletedTicket;
use App\Enums\Difficulty;
use App\Models\CompletedTicket;
use App\Models\Hero;
use App\Models\Ticket;

test('creates hero if not exists', function () {
    $action = app(AddCompletedTicket::class);

    $action->handle('NewHero', 'TICK-001', Difficulty::Easy);

    expect(Hero::where('name', 'NewHero')->exists())->toBeTrue();
});

test('reuses existing hero', function () {
    Hero::factory()->create(['name' => 'ExistingHero']);

    $action = app(AddCompletedTicket::class);
    $action->handle('ExistingHero', 'TICK-001', Difficulty::Easy);

    expect(Hero::where('name', 'ExistingHero')->count())->toBe(1);
});

test('creates ticket with correct attributes', function () {
    $action = app(AddCompletedTicket::class);

    $ticket = $action->handle('Alice', 'JIRA-101', Difficulty::Hard);

    expect($ticket->ticket_id)->toBe('JIRA-101')
        ->and($ticket->difficulty)->toBe(Difficulty::Hard)
        ->and($ticket->hero->name)->toBe('Alice');
});

test('creates completed ticket record', function () {
    $action = app(AddCompletedTicket::class);

    $ticket = $action->handle('Alice', 'JIRA-101', Difficulty::Easy);

    expect(CompletedTicket::where('ticket_id', $ticket->id)->exists())->toBeTrue();
});

test('does not duplicate ticket on repeat call', function () {
    $action = app(AddCompletedTicket::class);

    $action->handle('Alice', 'JIRA-101', Difficulty::Easy);
    $action->handle('Alice', 'JIRA-101', Difficulty::Easy);

    expect(Ticket::where('ticket_id', 'JIRA-101')->count())->toBe(1);
});

test('does not duplicate completed ticket on repeat call', function () {
    $action = app(AddCompletedTicket::class);

    $action->handle('Alice', 'JIRA-101', Difficulty::Easy);
    $action->handle('Alice', 'JIRA-101', Difficulty::Easy);

    expect(CompletedTicket::count())->toBe(1);
});
