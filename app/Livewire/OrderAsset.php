<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\User;

use App\Jobs\ModerateReview;

class OrderAsset extends Component
{
    public $allOrders;
    public $pendingOrders;
    public $approvedOrders;
    public $activeTab = 'all';
    public $showModal = false;
    public $selectedAssetId = null;
    public $rating;
    public $comment;

    public function render()
    {
        if ($this->activeTab === 'all') {
            $this->allOrders = Order::where('user_id', auth()->id())
                ->with('items.asset')
                ->latest()
                ->get();
        }

        if ($this->activeTab === 'pending') {
            $this->pendingOrders = Order::where('user_id', auth()->id())
                ->where('status', 'pending')
                ->with('items.asset')
                ->latest()
                ->get();
        }

        if ($this->activeTab === 'approved') {
            $this->approvedOrders = Order::where('user_id', auth()->id())
                ->where('status', 'approved')
                ->with('items.asset')
                ->latest()
                ->get();
        }

        return view('livewire.assets.order-asset', [
            'pendingOrders' => $this->pendingOrders,
            'approvedOrders' => $this->approvedOrders,
        ])->layout('components.layouts.base');
    }

    public function pay($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $order->status = 'approved';
        $order->save();

        session()->flash('message', "Order #{$order->id} paid succesfuly!");
    }

    public function payWithMercadoPago(Order $order)
    {
        return redirect()->route('payment.create', $order->id);
    }

    public function review()
    {
        if (Review::where('user_id', auth()->id())
            ->where('asset_id', $this->selectedAssetId)
            ->exists()) {
            session()->flash('message', 'You already rated this asset.');
            return;
        }

        $review = Review::create([
            'user_id' => auth()->id(),
            'asset_id' => $this->selectedAssetId,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'status' => 'pending',
        ]);

         // envia para fila
        ModerateReview::dispatch($review->id);

        session()->flash('message', 'Your review has been sent and is under review.');

        $this->reset(['rating', 'comment', 'selectedAssetId']);
        $this->closeReviewModal();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function openReviewModal($assetId)
    {
        $this->selectedAssetId = $assetId;

        if (Review::where('user_id', auth()->id())
            ->where('asset_id', $this->selectedAssetId)
            ->exists()) {
            session()->flash('message', 'You already rated this asset.');
            $this->showModal = false;
        } else {
            $this->showModal = true;
        }

    }

    public function closeReviewModal()
    {
        $this->showModal = false;
        $this->selectedAssetId = null;
    }
}
