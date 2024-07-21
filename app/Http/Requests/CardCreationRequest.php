<?php

namespace App\Http\Requests;

use App\Enums\BankingProduct;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CardCreationRequest extends FormRequest
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
            'bankingProduct' => ['required', 'string', Rule::enum(BankingProduct::class)],
            'currency' => ['required', 'string', 'max:6', 'exists:exchange_rates,code']
        ];
    }
}
