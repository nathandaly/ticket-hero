<?php

namespace App\Http\Controllers\Tickets;

use App\Actions\Tickets\AddCompletedTicket;
use App\Enums\Difficulty;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\StoreTicketRequest;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    public function __construct(private readonly AddCompletedTicket $addCompletedTicket) {}

    public function __invoke(StoreTicketRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $ticket = $this->addCompletedTicket->handle(
            heroName: $validated['heroName'],
            ticketId: $validated['ticketId'],
            difficulty: Difficulty::from($validated['difficulty']),
        );

        /** @var Difficulty $difficulty */
        $difficulty = $ticket->difficulty;

        return response()->json([
            'ticket_id' => $ticket->ticket_id,
            'hero' => $ticket->hero->name,
            'xp' => $difficulty->xp(),
        ], 201);
    }
}
