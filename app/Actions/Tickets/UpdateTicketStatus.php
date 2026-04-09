<?php

namespace App\Actions\Tickets;

use App\Enums\TicketStatus;
use App\Models\CompletedTicket;
use App\Models\Ticket;

class UpdateTicketStatus
{
    public function handle(Ticket $ticket, TicketStatus $newStatus): Ticket
    {
        $previousStatus = $ticket->status;

        $ticket->update(['status' => $newStatus]);

        if ($newStatus === TicketStatus::Done && $previousStatus !== TicketStatus::Done) {
            CompletedTicket::firstOrCreate(
                ['ticket_id' => $ticket->id],
                ['hero_id' => $ticket->hero_id],
            );
        }

        if ($previousStatus === TicketStatus::Done && $newStatus !== TicketStatus::Done) {
            $ticket->completedTicket?->delete();
        }

        return $ticket->refresh();
    }
}
