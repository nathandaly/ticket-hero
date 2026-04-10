<?php

use App\Enums\TicketStatus;
use App\Models\CompletedTicket;
use App\Models\Ticket;

test('updates ticket status via patch', function () {
    $ticket = Ticket::factory()->create(['status' => TicketStatus::Todo]);

    $this->patch("/tickets/{$ticket->id}/status", [
        'status' => 'in_progress',
    ])->assertRedirect();

    expect($ticket->refresh()->status)->toBe(TicketStatus::InProgress);
});

test('returns validation error for invalid status', function () {
    $ticket = Ticket::factory()->create();

    $this->patch("/tickets/{$ticket->id}/status", [
        'status' => 'invalid',
    ])->assertSessionHasErrors(['status']);
});

test('returns validation error for missing status', function () {
    $ticket = Ticket::factory()->create();

    $this->patch("/tickets/{$ticket->id}/status", [])
        ->assertSessionHasErrors(['status']);
});

test('moving to done creates completed ticket', function () {
    $ticket = Ticket::factory()->create(['status' => TicketStatus::InProgress]);

    $this->patch("/tickets/{$ticket->id}/status", [
        'status' => 'done',
    ]);

    expect(CompletedTicket::where('ticket_id', $ticket->id)->exists())->toBeTrue();
});

test('moving from done removes completed ticket', function () {
    $ticket = Ticket::factory()->done()->create();
    CompletedTicket::factory()->create([
        'ticket_id' => $ticket->id,
        'hero_id' => $ticket->hero_id,
    ]);

    $this->patch("/tickets/{$ticket->id}/status", [
        'status' => 'todo',
    ]);

    expect(CompletedTicket::where('ticket_id', $ticket->id)->exists())->toBeFalse();
});
