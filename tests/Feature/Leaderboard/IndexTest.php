<?php

use App\Enums\Difficulty;
use App\Models\CompletedTicket;
use App\Models\Hero;
use App\Models\Ticket;
use Inertia\Testing\AssertableInertia;

test('leaderboard page renders', function () {
    $this->get('/leaderboard')->assertOk();
});

test('leaderboard page receives leaderboard prop', function () {
    $this->get('/leaderboard')
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('leaderboard/index')
            ->has('leaderboard')
        );
});

test('api endpoint returns json', function () {
    $this->getJson('/api/leaderboard')
        ->assertOk()
        ->assertJsonStructure([]);
});

test('leaderboard shows correct data after completing tickets', function () {
    $hero = Hero::factory()->create(['name' => 'Alice']);
    $ticket = Ticket::factory()->done()->create([
        'hero_id' => $hero->id,
        'difficulty' => Difficulty::Legendary,
    ]);
    CompletedTicket::factory()->create([
        'ticket_id' => $ticket->id,
        'hero_id' => $hero->id,
    ]);

    $this->get('/leaderboard')
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('leaderboard/index')
            ->has('leaderboard', 1)
            ->where('leaderboard.0.hero_name', 'Alice')
            ->where('leaderboard.0.total_xp', 50)
            ->where('leaderboard.0.completed_tickets', 1)
        );
});
