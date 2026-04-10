<?php

use App\Actions\Tickets\CreateTicket;
use App\Enums\Difficulty;
use App\Enums\TicketStatus;
use App\Models\Hero;

test('creates ticket with all fields', function () {
    $hero = Hero::factory()->create();
    $action = app(CreateTicket::class);

    $ticket = $action->handle(
        title: 'Fix login bug',
        ticketId: 'JIRA-101',
        difficulty: Difficulty::Hard,
        heroId: $hero->id,
    );

    expect($ticket->title)->toBe('Fix login bug')
        ->and($ticket->ticket_id)->toBe('JIRA-101')
        ->and($ticket->difficulty)->toBe(Difficulty::Hard)
        ->and($ticket->hero_id)->toBe($hero->id)
        ->and($ticket->status)->toBe(TicketStatus::Todo);
});

test('defaults status to todo', function () {
    $hero = Hero::factory()->create();
    $action = app(CreateTicket::class);

    $ticket = $action->handle('Title', 'JIRA-102', Difficulty::Easy, $hero->id);

    expect($ticket->status)->toBe(TicketStatus::Todo);
});

test('respects provided status', function () {
    $hero = Hero::factory()->create();
    $action = app(CreateTicket::class);

    $ticket = $action->handle('Title', 'JIRA-103', Difficulty::Easy, $hero->id, TicketStatus::InProgress);

    expect($ticket->status)->toBe(TicketStatus::InProgress);
});
