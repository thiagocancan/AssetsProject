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
                'file_path' => 'assets/tT5WVRlyXvGceBP9A2g1hQCsmybqPEN4PulJ4qwC.jpg',
                'preview_path' => 'assets/preview_path/tT5WVRlyXvGceBP9A2g1hQCsmybqPEN4PulJ4qwC.jpg',
                'storage_disk' => 'private',
                'price' => random_int(1, 20),
            ]);
        }
    }
}
