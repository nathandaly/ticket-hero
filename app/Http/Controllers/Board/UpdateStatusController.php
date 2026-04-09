<?php

namespace App\Http\Controllers\Board;

use App\Actions\Tickets\UpdateTicketStatus;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Board\UpdateTicketStatusRequest;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;

class UpdateStatusController extends Controller
{
    public function __construct(private readonly UpdateTicketStatus $updateTicketStatus) {}

    public function __invoke(UpdateTicketStatusRequest $request, Ticket $ticket): RedirectResponse
    {
        $this->updateTicketStatus->handle(
            ticket: $ticket,
            newStatus: TicketStatus::from($request->validated('status')),
        );

        return back();
    }
}
