<?php

namespace Database\Factories;

use App\Enums\PaymentSystem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Billing>
 */
class BillingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'external_card_id' => $this->faker->creditCardNumber(),
            'system' => PaymentSystem::cases()[array_rand(PaymentSystem::cases())],
            'last_four_digits' => (string)$this->faker->numberBetween(1000, 9999),
            'user_id' => User::all()->random()->id,
        ];
    }
}
