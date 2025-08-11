<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'category' => $this->faker->randomElement(['natureza', 'tecnologia', 'arte', 'pessoas']),
            'type' => $this->faker->randomElement(['image', 'video', '3d_model']),
            'file_path' => $this->faker->imageUrl(),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
