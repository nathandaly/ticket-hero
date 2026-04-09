<?php

namespace App\Http\Controllers\Tickets;

use App\Enums\Difficulty;
use App\Http\Controllers\Controller;
use App\Models\Hero;
use Inertia\Inertia;
use Inertia\Response;

class CreateController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('tickets/create', [
            'heroes' => Hero::orderBy('name')->get(['id', 'name']),
            'difficulties' => array_map(
                fn (Difficulty $d) => ['value' => $d->value, 'label' => $d->name, 'xp' => $d->xp()],
                Difficulty::cases(),
            ),
        ]);
    }
}
