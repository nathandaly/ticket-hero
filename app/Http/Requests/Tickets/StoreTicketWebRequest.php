<?php

namespace App\Http\Requests\Tickets;

use App\Enums\Difficulty;
use App\Enums\TicketStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreTicketWebRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'ticketId' => ['required', 'string', 'max:255', 'unique:tickets,ticket_id'],
            'difficulty' => ['required', 'integer', new Enum(Difficulty::class)],
            'heroId' => ['required', 'integer', 'exists:heroes,id'],
            'status' => ['sometimes', 'string', new Enum(TicketStatus::class)],
        ];
    }
}
