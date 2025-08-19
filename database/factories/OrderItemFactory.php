<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => \App\Models\Order::factory(),
            'asset_id' => \App\Models\Asset::factory(),
            'price' => \App\Models\Asset::factory()->create()->price,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
