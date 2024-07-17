<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetAccountIdRequest extends FormRequest
{
    public function authorize()
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
            'accountId' => ['required', 'integer', 'exists:accounts,id'],
        ];
    }
}
