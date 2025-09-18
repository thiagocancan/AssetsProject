<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Asset;
use App\Models\Order;
use App\Models\Review;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(AssetSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(ReviewSeeder::class);
    }
}
