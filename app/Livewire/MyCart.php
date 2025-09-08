<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Asset;


class MyCart extends Component
{
    public $order;
    public $successMessage;
    public $errorMessage;
    public $error;
    public $user;

    public function render()
    {
        return view('livewire.assets.my-cart',[
        ])->layout('components.layouts.base');
    }

    public function clearCart()
    {
        session()->forget('cart');
        $this->cart = [];
    }

    public function removeFromCart($assetId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$assetId])) {
            unset($cart[$assetId]);
            session()->put('cart', $cart);
        }
    }

    public function makeOrder()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            $this->error = 'the cart is empty.';
            return;
        }

        $alreadyBought = [];

        foreach ($cart as $assetId => $item) {
            $asset = Asset::find($assetId);
            if (!$asset) continue;

            if (auth()->user()->hasBought($asset)) {
                $alreadyBought[] = $asset->title;
            }
        }

        if (!empty($alreadyBought)) {
            $this->error = 'You already bought these items: "' . implode(', ', $alreadyBought) . '". Remove them from the cart to continue.';
            return;
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total' => collect($cart)->sum(fn($item) => $item['price']),
        ]);

        foreach ($cart as $assetId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'asset_id' => $assetId,
                'price' => $item['price'],
            ]);
        }

        session()->forget('cart');
        $this->successMessage = "Successful order!";

        return redirect()->route('myOrders');
    }
}
