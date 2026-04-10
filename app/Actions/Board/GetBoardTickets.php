<?php

namespace App\Actions\Board;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use Illuminate\Support\Collection;

class GetBoardTickets
{
    /**
     * @return array{todo: Collection<int, Ticket>, in_progress: Collection<int, Ticket>, done: Collection<int, Ticket>}
     */
    public function handle(): array
    {
        $tickets = Ticket::with('hero')
            ->orderByDesc('updated_at')
            ->get();

        return [
            'todo' => $tickets->where('status', TicketStatus::Todo)->values(),
            'in_progress' => $tickets->where('status', TicketStatus::InProgress)->values(),
            'done' => $tickets->where('status', TicketStatus::Done)->values(),
        ];
    }
}
