<?php

use App\Enums\TicketStatus;
use App\Models\Ticket;
use Inertia\Testing\AssertableInertia;

test('board page renders', function () {
    $this->get('/board')->assertOk();
});

test('board page receives columns prop', function () {
    Ticket::factory()->create(['status' => TicketStatus::Todo]);
    Ticket::factory()->create(['status' => TicketStatus::InProgress]);
    Ticket::factory()->create(['status' => TicketStatus::Done]);

    $this->get('/board')
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('board/index')
            ->has('columns.todo', 1)
            ->has('columns.in_progress', 1)
            ->has('columns.done', 1)
        );
});
