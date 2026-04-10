<?php

namespace Database\Seeders;

use App\Enums\Difficulty;
use App\Enums\TicketStatus;
use App\Models\CompletedTicket;
use App\Models\Hero;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $heroes = collect([
            'Alice', 'Bob', 'Charlie', 'Diana', 'Ethan',
            'Fiona', 'George', 'Hannah', 'Ivan', 'Julia',
        ])->map(fn (string $name) => Hero::factory()->create(['name' => $name]));

        $tickets = [
            ['title' => 'Fix login bug', 'difficulty' => Difficulty::Hard],
            ['title' => 'Add search feature', 'difficulty' => Difficulty::Medium],
            ['title' => 'Refactor auth middleware', 'difficulty' => Difficulty::Expert],
            ['title' => 'Update API docs', 'difficulty' => Difficulty::Easy],
            ['title' => 'Add pagination to list', 'difficulty' => Difficulty::Easy],
            ['title' => 'Setup CI pipeline', 'difficulty' => Difficulty::Medium],
            ['title' => 'Design dashboard layout', 'difficulty' => Difficulty::Hard],
            ['title' => 'Implement dark mode', 'difficulty' => Difficulty::Medium],
            ['title' => 'Write unit tests for auth', 'difficulty' => Difficulty::Hard],
            ['title' => 'Migrate to PostgreSQL', 'difficulty' => Difficulty::Legendary],
            ['title' => 'Add email notifications', 'difficulty' => Difficulty::Medium],
            ['title' => 'Fix memory leak in queue', 'difficulty' => Difficulty::Expert],
            ['title' => 'Build onboarding flow', 'difficulty' => Difficulty::Hard],
            ['title' => 'Add two-factor auth', 'difficulty' => Difficulty::Expert],
            ['title' => 'Optimise N+1 queries', 'difficulty' => Difficulty::Hard],
            ['title' => 'Add CSV export', 'difficulty' => Difficulty::Easy],
            ['title' => 'Create admin panel', 'difficulty' => Difficulty::Legendary],
            ['title' => 'Fix timezone handling', 'difficulty' => Difficulty::Medium],
            ['title' => 'Add rate limiting', 'difficulty' => Difficulty::Medium],
            ['title' => 'Write API integration tests', 'difficulty' => Difficulty::Hard],
            ['title' => 'Upgrade to PHP 8.4', 'difficulty' => Difficulty::Expert],
            ['title' => 'Implement SSE notifications', 'difficulty' => Difficulty::Expert],
            ['title' => 'Add file upload support', 'difficulty' => Difficulty::Medium],
            ['title' => 'Fix broken password reset', 'difficulty' => Difficulty::Easy],
            ['title' => 'Add audit logging', 'difficulty' => Difficulty::Hard],
            ['title' => 'Improve error messages', 'difficulty' => Difficulty::Easy],
            ['title' => 'Add WebSocket support', 'difficulty' => Difficulty::Legendary],
            ['title' => 'Refactor billing module', 'difficulty' => Difficulty::Expert],
            ['title' => 'Add multi-language support', 'difficulty' => Difficulty::Hard],
            ['title' => 'Write E2E smoke tests', 'difficulty' => Difficulty::Medium],
            ['title' => 'Cache expensive reports', 'difficulty' => Difficulty::Medium],
            ['title' => 'Implement soft deletes', 'difficulty' => Difficulty::Easy],
            ['title' => 'Add Slack integration', 'difficulty' => Difficulty::Hard],
            ['title' => 'Fix CORS configuration', 'difficulty' => Difficulty::Easy],
            ['title' => 'Set up feature flags', 'difficulty' => Difficulty::Medium],
        ];

        foreach ($tickets as $index => $data) {
            $hero = $heroes[$index % $heroes->count()];
            $ticketId = 'TICK-'.str_pad((string) ($index + 101), 5, '0', STR_PAD_LEFT);

            // Spread tickets: ~40% done, ~20% in progress, ~40% todo
            $status = match (true) {
                $index % 5 === 0 || $index % 5 === 1 => TicketStatus::Done,
                $index % 5 === 2 => TicketStatus::InProgress,
                default => TicketStatus::Todo,
            };

            $ticket = Ticket::factory()
                ->state(['status' => $status])
                ->create([
                    'hero_id' => $hero->id,
                    'ticket_id' => $ticketId,
                    'title' => $data['title'],
                    'difficulty' => $data['difficulty'],
                ]);

            if ($status === TicketStatus::Done) {
                CompletedTicket::factory()->create([
                    'ticket_id' => $ticket->id,
                    'hero_id' => $hero->id,
                ]);
            }
        }
    }
}
