<?php

namespace App\Actions\Tickets;

use App\Enums\Difficulty;
use App\Enums\TicketStatus;
use App\Models\Ticket;

class CreateTicket
{
    public function handle(string $title, string $ticketId, Difficulty $difficulty, int $heroId, TicketStatus $status = TicketStatus::Todo): Ticket
    {
        return Ticket::create([
            'title' => $title,
            'ticket_id' => $ticketId,
            'difficulty' => $difficulty,
            'hero_id' => $heroId,
            'status' => $status,
        ]);
    }
}
