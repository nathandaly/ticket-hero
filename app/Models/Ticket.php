<?php

namespace App\Models;

use App\Enums\Difficulty;
use App\Enums\TicketStatus;
use Database\Factories\TicketFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['hero_id', 'ticket_id', 'title', 'difficulty', 'status'])]
class Ticket extends Model
{
    /** @use HasFactory<TicketFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'difficulty' => Difficulty::class,
            'status' => TicketStatus::class,
        ];
    }

    /** @return BelongsTo<Hero, $this> */
    public function hero(): BelongsTo
    {
        return $this->belongsTo(Hero::class);
    }

    /** @return HasOne<CompletedTicket, $this> */
    public function completedTicket(): HasOne
    {
        return $this->hasOne(CompletedTicket::class);
    }
}