<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cardNumber = fake()->creditCardNumber();

        return [
            'card_number' => $cardNumber,
            'card_last_digits' => substr($cardNumber, -4),
            'expiry_date' => fake()->creditCardExpirationDate(),
            'balance' => fake()->randomFloat(2, 0, 30000),
            'currency' => fake()->currencyCode(),
            'banking_product' => fake()->randomElement(['Personal', 'Company']),
        ];
    }
}