<?php

namespace Database\Factories;

use App\Enums\Difficulty;
use App\Enums\TicketStatus;
use App\Models\Hero;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Ticket> */
class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'hero_id' => Hero::factory(),
            'ticket_id' => fn () => 'TICK-'.fake()->unique()->randomNumber(5, true),
            'title' => fake()->sentence(4),
            'difficulty' => fake()->randomElement(Difficulty::cases()),
            'status' => TicketStatus::Todo,
        ];
    }

    public function done(): static
    {
        return $this->state(['status' => TicketStatus::Done]);
    }

    public function inProgress(): static
    {
        return $this->state(['status' => TicketStatus::InProgress]);
    }
}
