<?php

namespace App\Http\Requests\Tickets;

use App\Enums\Difficulty;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'heroName' => ['required', 'string', 'max:255'],
            'ticketId' => ['required', 'string', 'max:255'],
            'difficulty' => ['required', 'integer', new Enum(Difficulty::class)],
        ];
    }
}
