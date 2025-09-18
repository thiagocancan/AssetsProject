<div>
    <div class="bg-orange-600/90 p-8 w-full absolute left-0 -z-30"> <h2 class="text-amber-50/0 text-1xl">My Cart</h2></div>
    <div class="bg-orange-600/0 py-8 mb-6">
        <h2 class="text-amber-50 text-2xl">My Orders</h2>
    </div>

    @if (session('message'))
        <div 
            x-data="{ show: true }" 
            x-init="setTimeout(() => show = false, 3000)" 
            x-show="show"
            class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg"
        >
            {{ session('message') }}
        </div>
    @endif

    <div>
        <div class="mb-6 w-fit ml-3 text-zinc-500 space-x-2">
            <button 
                wire:click="setTab('all')" 
                class="hover:text-black cursor-pointer border-black
                    @if($activeTab === 'all') border-b text-black @endif">All Orders
            </button>
            <button 
                wire:click="setTab('pending')" 
                class="hover:text-black cursor-pointer border-black 
                    @if($activeTab === 'pending') border-b text-black @endif">
                Pending Orders
            </button>
            <button 
                wire:click="setTab('approved')" 
                class="hover:text-black cursor-pointer border-black
                    @if($activeTab === 'approved') border-b text-black @endif">Approved Orders
            </button>
        </div>

        @if($activeTab === 'all')
            <div class="space-y-4">
                @foreach($allOrders as $allOrder)
                    <div class="border border-zinc-300 rounded p-6 space-y-4">
                        <div class="flex justify-between">
                            <h2 class="font-medium text-sm">Order #{{ $allOrder->id }} <span class="bg-orange-600/90 text-amber-50 px-1 py-1 rounded text-[11px]">{{ $allOrder->status }}</span></h2>
                            <p class="text-sm">{{ $allOrder->created_at }}</p>
                        </div>
                        @foreach ($allOrder->items as $item)
                            <div>
                                <h2 class="text-sm text-zinc-700 font-light">- {{ $item->asset->title }} - ${{ number_format($item->asset->price, 2) }}</h2>
                            </div>
                        @endforeach
                        <p class="text-sm text-zinc-700">Total: ${{ number_format($allOrder->total, 2) }}</p>
                        @if($allOrder->status === 'pending')
                            <button wire:click="pay({{ $allOrder->id }})" class="border px-4 py-1 border-orange-600/90 text-[13px] cursor-pointer">Simulate Payment</button>
                            <button wire:click="payWithMercadoPago({{ $allOrder }})" class="border px-4 py-1 border-orange-600/90 text-[13px] cursor-pointer">Pay With Mercado Pago</button>
                        @endif
                    </div>
                @endforeach
            </div>
        @elseif($activeTab === 'pending')
            <div class="space-y-4">
                @foreach($pendingOrders as $pendingOrder)
                    <div class="border border-zinc-300 rounded p-6 space-y-4">
                        <div class="flex justify-between">
                            <h2 class="font-medium text-sm">Order #{{ $pendingOrder->id }} <span class="bg-orange-600/90 text-amber-50 px-1 py-1 rounded text-[11px]">{{ $pendingOrder->status }}</span></h2>
                            <p class="text-sm">{{ $pendingOrder->created_at }}</p>
                        </div>
                        @foreach ($pendingOrder->items as $item)
                            <div>
                                <h2 class="text-sm text-zinc-700 font-light">- {{ $item->asset->title }} - ${{ number_format($item->asset->price, 2) }}</h2>
                            </div>
                        @endforeach
                        <p class="text-sm text-zinc-700">Total: ${{ number_format($pendingOrder->total, 2) }}</p>
                        <button wire:click="pay({{ $pendingOrder->id }})" class="border px-4 py-1 border-orange-600/90 text-[13px] cursor-pointer">Simulate Payment</button>
                        <button wire:click="payWithMercadoPago({{ $pendingOrder }})" class="border px-4 py-1 border-orange-600/90 text-[13px] cursor-pointer">Pay With Mercado Pago</button>
                    </div>
                @endforeach
            </div>
        @elseif($activeTab === 'approved')
            <div class="space-y-4">
                @foreach($approvedOrders as $approvedOrder)
                    <div class="border border-zinc-300 rounded p-6 space-y-4">
                        <div class="flex justify-between">
                            <h2 class="font-medium text-sm">Order #{{ $approvedOrder->id }} <span class="bg-orange-600/90 text-amber-50 px-1 py-1 rounded text-[11px]">{{ $approvedOrder->status }}</span></h2>
                            <p class="text-sm">{{ $approvedOrder->created_at }}</p>
                        </div>
                        @foreach ($approvedOrder->items as $item)
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('assets.asset-page', $item->asset->id) }}" class="text-sm"><span class="text-orange-600/90">{{ $item->asset->title }}</span> - ${{ number_format($item->asset->price, 2) }}</a>
                                <button wire:click="openReviewModal({{ $item->asset->id }})" class="border px-1 py-1 border-orange-600/90 text-[13px] cursor-pointer">Review</button>
                            </div>
                        @endforeach
                        <p class="text-sm text-zinc-700">Total: ${{ number_format($approvedOrder->total, 2) }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
            <div class="bg-white p-6 rounded shadow-lg w-96">
                <h2 class="text-lg font-semibold mb-4">Leave your review</h2>
                
                <form wire:submit.prevent="review">
                    <input type="hidden" wire:model="selectedAssetId">

                    <label class="block mb-2">Rating:</label>
                    <select wire:model="rating" class="border rounded p-2 mb-3 w-full">
                        <option value="">Select</option>
                        <option value="1">⭐</option>
                        <option value="2">⭐⭐</option>
                        <option value="3">⭐⭐⭐</option>
                        <option value="4">⭐⭐⭐⭐</option>
                        <option value="5">⭐⭐⭐⭐⭐</option>
                    </select>

                    <textarea 
                        wire:model="comment"
                        rows="4"
                        class="w-full border rounded p-2 mb-3"
                        placeholder="Write your review..."
                    ></textarea>

                    <div class="flex justify-end gap-2">
                        <button 
                            type="button" 
                            wire:click="closeReviewModal"
                            class="px-4 py-2 border rounded"
                        >
                            Cancel
                        </button>
                        <button 
                            type="submit" 
                            class="px-4 py-2 bg-orange-600 text-white rounded"
                        >
                            Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
