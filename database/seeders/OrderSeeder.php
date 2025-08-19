<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\Asset;
use App\Models\OrderItem;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $assets = Asset::all();

        // Create 15 orders
        foreach ($users as $user) {
            $numberOfOrders = rand(1, 3);

            for ($i = 0; $i < $numberOfOrders; $i++) {
                // Create order
                $order = Order::create([
                    'user_id' => $user->id,
                    'status' => rand(0, 1) ? 'pending' : 'completed',
                    'total' => 0, 
                ]);

                // Add 1-5 random items to order
                $numberOfItems = rand(1, 5);
                $total = 0;

                for ($j = 0; $j < $numberOfItems; $j++) {
                    $asset = $assets->random();
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'asset_id' => $asset->id,
                        'price' => $asset->price,
                    ]);

                    $total += $asset->price;
                }

                // Update order total
                $order->update(['total' => $total]);
            }
        }
    }
}
