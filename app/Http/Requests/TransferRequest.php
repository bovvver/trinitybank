<?php

namespace App\Http\Requests;

use App\Enums\TransferCategories;
use App\Rules\DateInFuture;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'receiver' => $this->sanitizeInput($this->receiver),
            'message' => $this->sanitizeInput($this->message),
            'category' => $this->sanitizeInput($this->category),
            'sender_card' => preg_replace('/\D/', '', $this->sender_card),
            'account_number' => preg_replace('/\D/', '', $this->account_number),
            'amount' => filter_var($this->amount, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
            'date' => $this->sanitizeInput($this->date),
        ]);
    }

    /**
     * Sanitize input to remove HTML tags and convert special characters to safe entities.
     *
     * @param string|null $input
     * @return string
     */
    protected function sanitizeInput(?string $input): string
    {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'receiver' => ['required', 'string', 'max:50'],
            'message' => ['string', 'max:50'],
            'category' => ['required', 'string', 'max:50', Rule::enum(TransferCategories::class)],
            'sender_card' => ['required', 'numeric', 'digits:4', 'exists:accounts,card_last_digits'],
            'account_number' => ['required', 'numeric', 'digits:11', 'exists:accounts,account_number'],
            'amount' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', 'gt:0'],
            'date' => ['required', 'date', new DateInFuture],
        ];
    }
}