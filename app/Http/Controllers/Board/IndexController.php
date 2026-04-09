<?php

namespace App\Http\Controllers\Board;

use App\Actions\Board\GetBoardTickets;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class IndexController extends Controller
{
    public function __construct(private readonly GetBoardTickets $getBoardTickets) {}

    public function __invoke(): Response
    {
        return Inertia::render('board/index', [
            'columns' => $this->getBoardTickets->handle(),
        ]);
    }
}
