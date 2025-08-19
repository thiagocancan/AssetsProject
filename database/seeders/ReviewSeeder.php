<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Review;
use App\Models\Asset;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'test@gmail.com')->first();

        if ($user) {
            $assets = Asset::all();

            foreach ($assets as $asset) {
                Review::factory()->create([
                    'user_id' => $user->id,
                    'asset_id' => $asset->id,
                ]);
            }
        }

    }
}
