<?php

use App\Actions\Tickets\UpdateTicketStatus;
use App\Enums\TicketStatus;
use App\Models\CompletedTicket;
use App\Models\Hero;
use App\Models\Ticket;

test('updates status from todo to in progress', function () {
    $ticket = Ticket::factory()->create(['status' => TicketStatus::Todo]);
    $action = app(UpdateTicketStatus::class);

    $updated = $action->handle($ticket, TicketStatus::InProgress);

    expect($updated->status)->toBe(TicketStatus::InProgress);
});

test('moving to done creates completed ticket', function () {
    $hero = Hero::factory()->create();
    $ticket = Ticket::factory()->create([
        'hero_id' => $hero->id,
        'status' => TicketStatus::InProgress,
    ]);
    $action = app(UpdateTicketStatus::class);

    $action->handle($ticket, TicketStatus::Done);

    expect(CompletedTicket::where('ticket_id', $ticket->id)->exists())->toBeTrue()
        ->and(CompletedTicket::first()->hero_id)->toBe($hero->id);
});

test('moving from done deletes completed ticket', function () {
    $hero = Hero::factory()->create();
    $ticket = Ticket::factory()->done()->create(['hero_id' => $hero->id]);
    CompletedTicket::factory()->create([
        'ticket_id' => $ticket->id,
        'hero_id' => $hero->id,
    ]);

    $action = app(UpdateTicketStatus::class);
    $action->handle($ticket, TicketStatus::Todo);

    expect(CompletedTicket::where('ticket_id', $ticket->id)->exists())->toBeFalse();
});

test('round trip todo to done and back', function () {
    $ticket = Ticket::factory()->create(['status' => TicketStatus::Todo]);
    $action = app(UpdateTicketStatus::class);

    $action->handle($ticket, TicketStatus::Done);
    expect(CompletedTicket::where('ticket_id', $ticket->id)->exists())->toBeTrue();

    $action->handle($ticket, TicketStatus::Todo);
    expect(CompletedTicket::where('ticket_id', $ticket->id)->exists())->toBeFalse()
        ->and($ticket->refresh()->status)->toBe(TicketStatus::Todo);
});

test('moving to done when already done does not duplicate', function () {
    $ticket = Ticket::factory()->done()->create();
    CompletedTicket::factory()->create(['ticket_id' => $ticket->id, 'hero_id' => $ticket->hero_id]);
    $action = app(UpdateTicketStatus::class);

    $action->handle($ticket, TicketStatus::Done);

    expect(CompletedTicket::where('ticket_id', $ticket->id)->count())->toBe(1);
});
