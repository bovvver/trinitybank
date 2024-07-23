<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
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
            'file' => 'required|mimes:jpeg,png,jpg|max:5120',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'A file is required.',
            'file.mimes' => 'Only jpeg and png files are allowed.',
            'file.max' => 'Maximum file size is 5MB.',
        ];
    }
}
