<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Asset;
use App\Models\User;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Asset::factory()->count(20)->create([
                'user_id' => $user->id,
                'title' => fake()->words(3, true),
                'description' => fake()->paragraph(),
                'file_path' => 'assets/Zn5lujOllbMdxonvHwzLUwII3J6JNUrOhwtFFJGD.jpg',
                'preview_path' => 'assets/previewPath/Nedybaa1c13VQMdsqK88RI31XW6GTKFdFfPkx7nk.jpg',
                'storage_disk' => 'private',
                'type' => 'image',
                'price' => 1,
            ]);
        }
    }
}
