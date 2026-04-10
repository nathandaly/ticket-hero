<?php

use App\Actions\Leaderboard\GetLeaderboard;
use App\Enums\Difficulty;
use App\Models\CompletedTicket;
use App\Models\Hero;
use App\Models\Ticket;

test('returns empty collection when no completed tickets', function () {
    $result = app(GetLeaderboard::class)->handle();

    expect($result)->toBeEmpty();
});

test('single hero with one completed ticket', function () {
    $hero = Hero::factory()->create(['name' => 'Alice']);
    $ticket = Ticket::factory()->done()->create([
        'hero_id' => $hero->id,
        'difficulty' => Difficulty::Hard,
    ]);
    CompletedTicket::factory()->create([
        'ticket_id' => $ticket->id,
        'hero_id' => $hero->id,
    ]);

    $result = app(GetLeaderboard::class)->handle();

    expect($result)->toHaveCount(1)
        ->and($result->first()->hero_name)->toBe('Alice')
        ->and((int) $result->first()->total_xp)->toBe(30)
        ->and((int) $result->first()->completed_tickets)->toBe(1);
});

test('multiple heroes sorted by xp descending', function () {
    $alice = Hero::factory()->create(['name' => 'Alice']);
    $bob = Hero::factory()->create(['name' => 'Bob']);

    $t1 = Ticket::factory()->done()->create(['hero_id' => $alice->id, 'difficulty' => Difficulty::Easy]);
    CompletedTicket::factory()->create(['ticket_id' => $t1->id, 'hero_id' => $alice->id]);

    $t2 = Ticket::factory()->done()->create(['hero_id' => $bob->id, 'difficulty' => Difficulty::Legendary]);
    CompletedTicket::factory()->create(['ticket_id' => $t2->id, 'hero_id' => $bob->id]);

    $result = app(GetLeaderboard::class)->handle();

    expect($result)->toHaveCount(2)
        ->and($result->first()->hero_name)->toBe('Bob')
        ->and((int) $result->first()->total_xp)->toBe(50)
        ->and($result->last()->hero_name)->toBe('Alice')
        ->and((int) $result->last()->total_xp)->toBe(10);
});

test('heroes with same xp sorted alphabetically', function () {
    $bob = Hero::factory()->create(['name' => 'Bob']);
    $alice = Hero::factory()->create(['name' => 'Alice']);

    $t1 = Ticket::factory()->done()->create(['hero_id' => $bob->id, 'difficulty' => Difficulty::Medium]);
    CompletedTicket::factory()->create(['ticket_id' => $t1->id, 'hero_id' => $bob->id]);

    $t2 = Ticket::factory()->done()->create(['hero_id' => $alice->id, 'difficulty' => Difficulty::Medium]);
    CompletedTicket::factory()->create(['ticket_id' => $t2->id, 'hero_id' => $alice->id]);

    $result = app(GetLeaderboard::class)->handle();

    expect($result->first()->hero_name)->toBe('Alice')
        ->and($result->last()->hero_name)->toBe('Bob');
});

test('only counts completed tickets not all tickets', function () {
    $hero = Hero::factory()->create(['name' => 'Alice']);

    // A completed ticket
    $done = Ticket::factory()->done()->create(['hero_id' => $hero->id, 'difficulty' => Difficulty::Hard]);
    CompletedTicket::factory()->create(['ticket_id' => $done->id, 'hero_id' => $hero->id]);

    // A todo ticket (should not appear in XP)
    Ticket::factory()->create(['hero_id' => $hero->id, 'difficulty' => Difficulty::Legendary]);

    $result = app(GetLeaderboard::class)->handle();

    expect($result)->toHaveCount(1)
        ->and((int) $result->first()->total_xp)->toBe(30)
        ->and((int) $result->first()->completed_tickets)->toBe(1);
});

test('xp calculation matches difficulty times 10', function () {
    $hero = Hero::factory()->create();

    foreach (Difficulty::cases() as $difficulty) {
        $ticket = Ticket::factory()->done()->create([
            'hero_id' => $hero->id,
            'difficulty' => $difficulty,
        ]);
        CompletedTicket::factory()->create([
            'ticket_id' => $ticket->id,
            'hero_id' => $hero->id,
        ]);
    }

    $result = app(GetLeaderboard::class)->handle();
    $totalXp = (int) $result->first()->total_xp;

    // 10 + 20 + 30 + 40 + 50 = 150
    expect($totalXp)->toBe(150);
});
