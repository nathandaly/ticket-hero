<?php

namespace Database\Factories;

use App\Models\CompletedTicket;
use App\Models\Hero;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<CompletedTicket> */
class CompletedTicketFactory extends Factory
{
    protected $model = CompletedTicket::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::factory()->done(),
            'hero_id' => Hero::factory(),
            'completed_at' => now(),
        ];
    }
}
