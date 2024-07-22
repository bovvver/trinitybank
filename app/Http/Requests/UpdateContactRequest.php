<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
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
            'phoneNumber' => ['required', 'string', 'max:15', 'regex:/^(\([0-9]{3}\) ?|[0-9]{3}-)[0-9]{3}-[0-9]{4}$/', 'unique:users,phone_number'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
        ];
    }
}
