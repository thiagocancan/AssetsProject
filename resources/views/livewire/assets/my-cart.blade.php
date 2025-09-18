<div>
    @if ($successMessage)
        <div wire:poll.3s="$set('successMessage', null)" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-green-300/30 p-6 rounded shadow">
            {{ $successMessage }}
        </div>
    @elseif ($errorMessage)
        <div wire:poll.3s="$set('errorMessage', null)" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-orange-300/30 p-6 rounded shadow">
            {{ $errorMessage }}
        </div>
    @endif
    <div class="bg-orange-600/90 p-8 w-full absolute left-0 -z-30"> <h2 class="text-amber-50/0 text-1xl">My Cart</h2></div>
    <div class="bg-orange-600/0 py-8 mb-6">
        <h2 class="text-amber-50 text-2xl">My Cart</h2>
    </div>

    <button wire:click="clearCart" class="border p-1 border-orange-600/90 mb-3 text-[13px] cursor-pointer">Clear Cart</button>

    <div class="space-y-6">
        @if ($error)
            <div class="mt-3 rounded text-sm bg-zinc-700 text-amber-50 px-3 py-3 w-fit">
                ⚠️ {{ $error }}
            </div>
        @endif
        @foreach(session('cart', []) as $id => $item)
        <div class="flex space-x-5">   
            <img class="w-20" src="{{ asset('storage/' . $item['preview']) }}" alt="">
            <div class="flex flex-col justify-around w-lg">
                <div class="flex justify-between ">
                    <h2 class="text-orange-600/90">{{ $item['title'] }}</h2>
                    <p>${{ $item['price'] }}</p>
                </div>
                <div class="text-sm">Created by: {{ $item['creator'] }}</div>
                <button name="details" wire:click="removeFromCart('{{ $id }}')" class="border-b-1 border-black/50 text-black/50 text-[13px] cursor-pointer w-fit">Remove</button>
            </div>
        </div>
        @endforeach
        <div class="border-t">
            
        </div>
        <div class="flex justify-between">
            <h2 class="">Total: R$ {{ collect(session('cart', []))->sum(fn($item) => $item['price']) }}</h2>
            <button wire:click="makeOrder" class="border p-1 border-orange-600/90 mb-3 text-[13px] cursor-pointer">Purchase</button>
        </div>
    </div>
</div>
