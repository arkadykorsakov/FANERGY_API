<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubscriptionLevel>
 */
class SubscriptionLevelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word,
            'description' => $this->faker->text,
            'order' => $this->faker->numberBetween(1, 5),
            'price_per_month' => $this->faker->numberBetween(200, 1000),
            'user_id' => User::all()->random()->id,
        ];
    }
}
