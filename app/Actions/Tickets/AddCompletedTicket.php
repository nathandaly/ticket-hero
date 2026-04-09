<?php

namespace App\Actions\Tickets;

use App\Enums\Difficulty;
use App\Enums\TicketStatus;
use App\Models\CompletedTicket;
use App\Models\Hero;
use App\Models\Ticket;

class AddCompletedTicket
{
    public function handle(string $heroName, string $ticketId, Difficulty $difficulty): Ticket
    {
        $hero = Hero::firstOrCreate(['name' => $heroName]);

        $ticket = Ticket::firstOrCreate(
            ['ticket_id' => $ticketId],
            [
                'hero_id' => $hero->id,
                'title' => $ticketId,
                'difficulty' => $difficulty,
                'status' => TicketStatus::Done,
            ],
        );

        CompletedTicket::firstOrCreate(
            ['ticket_id' => $ticket->id],
            ['hero_id' => $hero->id],
        );

        return $ticket;
    }
}