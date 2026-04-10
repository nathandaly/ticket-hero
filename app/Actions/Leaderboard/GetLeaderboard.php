<?php

namespace App\Actions\Leaderboard;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use stdClass;

class GetLeaderboard
{
    /**
     * @return Collection<int, stdClass>
     */
    public function handle(): Collection
    {
        return DB::table('heroes')
            ->join('completed_tickets', 'completed_tickets.hero_id', '=', 'heroes.id')
            ->join('tickets', 'tickets.id', '=', 'completed_tickets.ticket_id')
            ->selectRaw('heroes.id as hero_id, heroes.name as hero_name, SUM(tickets.difficulty * 10) as total_xp, COUNT(completed_tickets.id) as completed_tickets')
            ->groupBy('heroes.id', 'heroes.name')
            ->orderByDesc('total_xp')
            ->orderBy('heroes.name')
            ->get();
    }
}
