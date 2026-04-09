<?php

namespace App\Models;

use Database\Factories\CompletedTicketFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['ticket_id', 'hero_id', 'completed_at'])]
class CompletedTicket extends Model
{
    /** @use HasFactory<CompletedTicketFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
        ];
    }

    /** @return BelongsTo<Ticket, $this> */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    /** @return BelongsTo<Hero, $this> */
    public function hero(): BelongsTo
    {
        return $this->belongsTo(Hero::class);
    }
}
