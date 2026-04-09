<?php

namespace App\Actions\Leaderboard;

use App\Models\Hero;
use Illuminate\Support\Collection;

class GetLeaderboard
{
    /** @return Collection<int, array{hero_name: string, total_xp: int, completed_tickets: int}> */
    public function handle(): Collection
    {
        return Hero::query()
            ->join('completed_tickets', 'completed_tickets.hero_id', '=', 'heroes.id')
            ->join('tickets', 'tickets.id', '=', 'completed_tickets.ticket_id')
            ->selectRaw('heroes.id as hero_id, heroes.name as hero_name, SUM(tickets.difficulty * 10) as total_xp, COUNT(completed_tickets.id) as completed_tickets')
            ->groupBy('heroes.id', 'heroes.name')
            ->orderByDesc('total_xp')
            ->orderBy('heroes.name')
            ->get();
    }
}