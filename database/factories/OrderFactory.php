<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'cancelled']),
            'total' => $this->faker->numberBetween(1000, 10000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
