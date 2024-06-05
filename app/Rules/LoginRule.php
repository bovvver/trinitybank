<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LoginRule implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/^(?!666|000|9\\d{2})\\d{3}-(?!00)\\d{2}-(?!0{4})\\d{4}$/', $value) ||
            filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public function message()
    {
        return 'Wrong Email or SSN Number.';
    }
}