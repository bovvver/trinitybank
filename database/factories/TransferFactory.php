<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transfer>
 */
class TransferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'message' => fake()->realText(40),
            'amount' => fake()->randomFloat(2, 1, 15000),
            'currency' => fake()->currencyCode(),
            'category' => fake()->randomElement(['Education', 'Food', 'Hygiene', 'Transport', 'Work', 'Investments', 'Others']),
            'dispatch_date' => fake()->date(),
        ];
    }
}
