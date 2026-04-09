<?php

namespace App\Models;

use Database\Factories\HeroFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name'])]
class Hero extends Model
{
    /** @use HasFactory<HeroFactory> */
    use HasFactory;

    /** @return HasMany<Ticket, $this> */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /** @return HasMany<CompletedTicket, $this> */
    public function completedTickets(): HasMany
    {
        return $this->hasMany(CompletedTicket::class);
    }
}