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
            'file_path' => 'assets/w1YyxCDNpB4qK2OAyvBV7cQx76QCLIZIo2nzcPZ6.obj',
            'preview_path' => 'public/assets/previewPath/QIyHMUf2N7VISWpOrFDou4zdSDyFz9dpRIhIDBEN.png',
            'price' => $this->faker->randomFloat(2, 1, 100),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
