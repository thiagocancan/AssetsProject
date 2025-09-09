<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display the user order list.
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.asset')
            ->get();
        
        return response()->json($orders, 200);
    }

    /**
     * Create a new order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.asset_id' => 'required|exists:assets,id',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total' => collect($validated['items'])->sum(function ($item) {
                return \App\Models\Asset::find($item['asset_id'])->price;
            }),
        ]);

        foreach ($validated['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'asset_id' => $item['asset_id'],
                'price' => \App\Models\Asset::find($item['asset_id'])->price,
            ]);
        }

        return response()->json([
            'message' => 'Order created successfully.',
            'order' => $order->load('items.asset')
        ], 201);
    }

    /**
     * Display the specified order.
     */
    public function show(string $id)
    {
        $order = Order::with('items.asset')->findOrFail($id);

        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($order, 200);
    }

    /**
     * Approve the specified order.
     */
    public function approve(string $id)
    {
        $order = Order::findOrFail($id);

        $order->status = 'completed';
        $order->save();

        return response()->json(['message' => 'Order approved successfully.'], 200);
    }

}
