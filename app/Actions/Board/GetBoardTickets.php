<?php

namespace App\Actions\Board;

use App\Enums\TicketStatus;
use App\Models\Ticket;

class GetBoardTickets
{
    /** @return array{todo: \Illuminate\Support\Collection, in_progress: \Illuminate\Support\Collection, done: \Illuminate\Support\Collection} */
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
