<div>
    <div class="bg-orange-600/90 px-6 mb-6">
        <div class="flex items-center text-amber-50 space-x-6 py-6 mx-auto max-w-7xl">
            <img class="rounded-full size-35" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="AvatarImage">
            <div class="space-y-4">
                <div class="flex">
                    <h1 class="text-2xl font-medium">{{ $user->name }}</h1>
                    <p class="text-sm">{{ $user->profile->location }}</p>
                </div>
                <p>6.2K Followers</p>
                <button class="border px-4 py-1 hover:border-zinc-700 hover:text-zinc-700 cursor-pointer">follow</button>
                <button class="border px-4 py-1 hover:border-zinc-700 hover:text-zinc-700 cursor-pointer">contact</button>
                <p class="text-sm">{{ $user->profile->bio }}</p>
            </div>
        </div>
    </div>

    <div>
        <div class="mb-6 w-fit ml-3 text-zinc-500 space-x-2">
            <button 
                wire:click="setTab('assets')" 
                class="hover:text-black cursor-pointer border-black 
                    @if($activeTab === 'assets') border-b text-black @endif">
                All Assets ({{ $assets_count }})
            </button>
            <button 
                wire:click="setTab('reviews')" 
                class="hover:text-black cursor-pointer border-black
                    @if($activeTab === 'reviews') border-b text-black @endif">Reviews ({{ $reviews_count }})
            </button>
        </div>

        @if($activeTab === 'assets')
            <div class="grid grid-cols-4 gap-6">
                @foreach($assets as $asset)
                    <div class="shadow-md">
                        <div class="h-50 flex flex-col justify-between p-4 bg-white dark:bg-gray-800" 
                            style="background-image: url('{{ asset('storage/' . $asset->preview_path) }}'); 
                            background-size: cover; background-position: center;">
                            <span class="bg-zinc-800 w-fit px-2 py-1 rounded text-sm text-accent-foreground">{{ $asset->type }}</span>
                            @if($asset->price  == 0)
                                <span class="self-end bg-green-300 w-fit px-2 py-1 text-sm">Free</span>
                            @else
                                <span class="self-end bg-orange-600/90 w-fit px-2 py-1 text-sm text-amber-50">R$ {{ number_format($asset->price, 2) }}</span>
                            @endif
                        </div>
                        <div class="p-4 bg-white dark:bg-gray-800 flex flex-col gap-2 h-50">
                            <h3 class="text-lg font-semibold">{{ $asset->title }}</h3>
                            <p class="text-zinc-500 font-normal text-sm truncate">{{ $asset->description }}</p>
                            <div class="flex items-center justify-between text-zinc-500 font-normal text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center justify-center text-amber-50 text-sm w-[24px] h-[24px] rounded-full bg-orange-500">JD</div>
                                    <span class="text-zinc-500 font-normal text-sm">{{ $asset->user->name }}</span>
                                </div>
                                <div class="text-zinc-500 font-normal text-sm">🌟 {{ number_format($asset->reviews->avg('rating'), 1) }}</div>
                            </div>
                            <div class="flex gap-2 mt-auto">
                                <a class="text-sm text-amber-50 bg-orange-600/90 py-1 px-3" href="{{ route('assets.asset-page', $asset->id) }}">Details</a>
                                <button class="py-1 px-3 border ">♥</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $assets->links() }}
            </div>
        @elseif($activeTab === 'reviews')
            <div class="space-y-3">
                @foreach($reviews as $review)
                    <div class="border border-zinc-300 rounded p-6 space-y-4">
                        <div class="flex justify-between">
                            <h2 class="font-semibold text-lg">{{ $review->asset->title }}</h2>
                            @for ($i = 0; $i < $review->rating; $i++)
                                ⭐
                            @endfor
                        </div>
                            <p class="text-sm text-zinc-700">{{ $review->comment }}</p>
                        <div class="flex items-center space-x-3">
                            <img class="rounded-full size-6" src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=random" alt="reviewer name">
                            <h3 class="text-sm">{{ $review->user->name }} - {{ $review->created_at->diffForHumans() }}</h3>
                        </div>
                    </div>
                @endforeach
                <div class="mt-4">
                    {{ $reviews->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
