<?php

namespace Database\Seeders;

use App\Enums\Difficulty;
use App\Enums\TicketStatus;
use App\Models\CompletedTicket;
use App\Models\Hero;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $alice = Hero::factory()->create(['name' => 'Alice']);
        $bob = Hero::factory()->create(['name' => 'Bob']);
        $charlie = Hero::factory()->create(['name' => 'Charlie']);

        // Alice: 2 done, 1 in progress
        $ticket1 = Ticket::factory()->done()->create([
            'hero_id' => $alice->id,
            'ticket_id' => 'JIRA-101',
            'title' => 'Fix login bug',
            'difficulty' => Difficulty::Hard,
        ]);
        CompletedTicket::factory()->create([
            'ticket_id' => $ticket1->id,
            'hero_id' => $alice->id,
        ]);

        $ticket2 = Ticket::factory()->done()->create([
            'hero_id' => $alice->id,
            'ticket_id' => 'JIRA-103',
            'title' => 'Add search feature',
            'difficulty' => Difficulty::Medium,
        ]);
        CompletedTicket::factory()->create([
            'ticket_id' => $ticket2->id,
            'hero_id' => $alice->id,
        ]);

        Ticket::factory()->inProgress()->create([
            'hero_id' => $alice->id,
            'ticket_id' => 'JIRA-106',
            'title' => 'Refactor auth middleware',
            'difficulty' => Difficulty::Expert,
        ]);

        // Bob: 1 done, 2 todo
        $ticket3 = Ticket::factory()->done()->create([
            'hero_id' => $bob->id,
            'ticket_id' => 'JIRA-102',
            'title' => 'Update API docs',
            'difficulty' => Difficulty::Legendary,
        ]);
        CompletedTicket::factory()->create([
            'ticket_id' => $ticket3->id,
            'hero_id' => $bob->id,
        ]);

        Ticket::factory()->create([
            'hero_id' => $bob->id,
            'ticket_id' => 'JIRA-104',
            'title' => 'Add pagination to list',
            'difficulty' => Difficulty::Easy,
        ]);

        Ticket::factory()->create([
            'hero_id' => $bob->id,
            'ticket_id' => 'JIRA-105',
            'title' => 'Setup CI pipeline',
            'difficulty' => Difficulty::Medium,
        ]);

        // Charlie: 1 todo
        Ticket::factory()->create([
            'hero_id' => $charlie->id,
            'ticket_id' => 'JIRA-107',
            'title' => 'Design dashboard layout',
            'difficulty' => Difficulty::Hard,
        ]);
    }
}
