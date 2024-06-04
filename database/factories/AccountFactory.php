<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

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
        return [
            'card_number' => fake()->creditCardNumber(),
            'cvv_number' => fake()->numberBetween(100, 999),
            'expiry_date' => fake()->creditCardExpirationDate(),
            'balance' => fake()->randomFloat(2, 0, 30000),
            'currency' => fake()->currencyCode(),
            'banking_product' => fake()->randomElement(['Personal', 'Company']),
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}