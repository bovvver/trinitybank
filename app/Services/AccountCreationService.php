<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Rules\StrongPassword;

class AccountCreationService extends Service
{
    // CREATION

    public function createUserWithAccount(Request $request): User
    {
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ssn_number' => $request->ssn_number,
            'phone_number' => $request->phone_number,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'street' => $request->street,
            'house_number' => $request->house_number,
        ]);

        $cardNumber = $this->generateUniqueNumber(13, 'card_number', true);

        Account::create([
            'user_id' => $user->id,
            'banking_product' => $request->banking_product,
            'card_number' => $cardNumber,
            'card_last_digits' => substr($cardNumber, -4),
            'account_number' => $this->generateUniqueNumber(11, 'account_number'),
            'expiry_date' => Carbon::now()->addYears(3),
            'balance' => 0,
            'currency' => 'USD',
        ]);

        return $user;
    }

    // VALIDATIONS 

    public function basicInfoValidation(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', StrongPassword::default()],
        ]);
    }
    public function personalInfoValidation(Request $request)
    {
        $request->validate([
            'ssn_number' => ['required', 'string', 'max:11', 'regex:/^(?!(000|666|9))\d{3}-(?!00)\d{2}-(?!0000)\d{4}$/', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:15', 'regex:/^(\([0-9]{3}\) ?|[0-9]{3}-)[0-9]{3}-[0-9]{4}$/', 'unique:users'],
            'city' => ['required', 'string', 'max:30'],
            'zip_code' => ['required', 'string', 'max:10', 'regex:/^\d{5}-\d{4}$/'],
            'street' => ['required', 'string', 'max:30'],
            'house_number' => ['required', 'string', 'max:7'],
        ]);
    }

    public function bankProductSelectionValidation(Request $request)
    {
        $request->validate([
            'banking_product' => ['required', 'string', 'in:Personal,Company'],
        ]);
    }

    // GENERATORS

    private function generateUniqueNumber($length, $field, $isCardNumber = false)
    {
        $number = $isCardNumber ? '33' : '';

        do {
            $newNumber = $number;
            for ($i = 0; $i < $length; $i++) {
                $newNumber .= mt_rand(0, 9);
            }
            if ($isCardNumber)
                $newNumber .= $this->calculateLuhnCheckDigit($newNumber);

            $exists = Account::where($field, $newNumber)->exists();
        } while ($exists);

        return $newNumber;
    }

    private function calculateLuhnCheckDigit($number)
    {
        $sum = 0;
        $length = strlen($number);
        for ($i = 0; $i < $length; $i++) {
            $digit = intval($number[$length - $i - 1]);
            if ($i % 2 == 0) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            $sum += $digit;
        }
        return (10 - ($sum % 10)) % 10;
    }
}