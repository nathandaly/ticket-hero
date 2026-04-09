<?php

namespace App\Http\Controllers\Tickets;

use App\Actions\Tickets\CreateTicket;
use App\Enums\Difficulty;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\StoreTicketWebRequest;
use Illuminate\Http\RedirectResponse;

class StoreWebController extends Controller
{
    public function __construct(private readonly CreateTicket $createTicket) {}

    public function __invoke(StoreTicketWebRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $this->createTicket->handle(
            title: $validated['title'],
            ticketId: $validated['ticketId'],
            difficulty: Difficulty::from($validated['difficulty']),
            heroId: $validated['heroId'],
        );

        return redirect()->route('board.index')->with('success', 'Ticket created successfully.');
    }
}
