<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Goal>
 */
class GoalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->text(),
            'amount_collected' => $this->faker->numberBetween(100, 1000),
            'total_collected' => $this->faker->numberBetween(1000, 100000),
            'user_id' => User::all()->random()->id,
        ];
    }
}
