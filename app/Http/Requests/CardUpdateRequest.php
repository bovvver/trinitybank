<?php

namespace App\Http\Requests;

use App\Enums\CardColors;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CardUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'newColor' => ['required', 'string', Rule::enum(CardColors::class)],
            'newStatus' => ['required', 'boolean'],
            'cardDigits' => ['required', 'string', 'max:4', 'exists:accounts,card_last_digits']
        ];
    }
}
