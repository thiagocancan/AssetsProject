<div>
    <div class="bg-orange-600/90 px-6 mb-6">
        <div class="flex items-center text-amber-50 space-x-6 py-6 mx-auto max-w-7xl">
            <img
                src="{{ 
                    $user->profile && $user->profile->avatar 
                        ? asset('storage/' . $user->profile->avatar) 
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random'
                }}" 
                alt="Profile" 
                class="size-35 cursor-pointer rounded-full"
            />
            <div class="space-y-4 w-full">
                <div class="flex justify-between items-center">
                    <div class="flex">
                        <h1 class="text-2xl font-medium">{{ $user->name }}</h1>
                        <p class="text-sm">{{ $user->profile->location }}</p>
                    </div>
                    @if(auth()->check() && auth()->id() === $user->id)
                        <a href="{{route('userupdate', '$user->id')}}" class="bg-amber-50 text-orange-600/90 text-sm rounded px-3 py-1">Edit Profile</a>
                    @endif
                </div>
                <p class="text-sm">{{ $user->profile->bio }}</p>
                <div>
                    <p class="text-sm">6.2K Followers</p>
                    <button class="text-sm border px-4 py-1 hover:border-zinc-700 hover:text-zinc-700 cursor-pointer">follow</button>
                    <button class="text-sm border px-4 py-1 hover:border-zinc-700 hover:text-zinc-700 cursor-pointer">contact</button>
                </div>
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
                    <a href="{{ route('assets.asset-page', $asset->id) }}">
                        <div class="shadow-md">
                            @if($asset->showType === 'img')
                                <div class="h-50 flex flex-col justify-between p-4 bg-white dark:bg-gray-800" 
                                    style="background-image: url('{{ asset('storage/' . $asset->preview_path) }}'); 
                                            background-size: cover; background-position: center;">
                                    <span class="bg-zinc-800 w-fit px-2 py-1 rounded text-sm text-accent-foreground">{{ $asset->type }}</span>
                                    @if($asset->price == 0)
                                        <span class="self-end bg-green-300 w-fit px-2 py-1 text-sm">Free</span>
                                    @else
                                        <span class="self-end bg-orange-600/90 w-fit px-2 py-1 text-sm text-amber-50">$ {{ number_format($asset->price, 2) }}</span>
                                    @endif
                                </div>
                            @else
                                <div class="relative h-50 w-full bg-white dark:bg-gray-800 overflow-hidden rounded">
                                    <video class="absolute top-0 left-0 w-full h-full object-cover pointer-events-none" autoplay muted loop>
                                        <source src="{{ asset('storage/' . $asset->preview_path) }}">
                                        Seu navegador não suporta o vídeo.
                                    </video>

                                    <div class="relative z-10 flex flex-col justify-between h-full w-full p-4">
                                        <span class="bg-zinc-800 w-fit px-2 py-1 rounded text-sm text-accent-foreground">{{ $asset->type }}</span>

                                        @if($asset->price == 0)
                                            <span class="bg-green-300 w-fit px-2 py-1 text-sm self-end">Free</span>
                                        @else
                                            <span class="bg-orange-600/90 w-fit px-2 py-1 text-sm text-amber-50 self-end">
                                                $ {{ number_format($asset->price, 2) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="p-4 bg-white dark:bg-gray-800 flex flex-col gap-2">
                                <h3 class="text-lg font-semibold truncate" title="{{ $asset->title }}">{{ $asset->title }}</h3>
                                <div class="flex items-center justify-between text-zinc-500 font-normal text-sm">
                                    <div class="flex items-center gap-2">
                                        <img
                                            src="{{ 
                                                $asset->user->profile && $asset->user->profile->avatar 
                                                    ? asset('storage/' . $asset->user->profile->avatar) 
                                                    : 'https://ui-avatars.com/api/?name=' . urlencode($asset->user->name) . '&background=random'
                                            }}" 
                                            alt="Profile" 
                                            class="size-6 cursor-pointer rounded-full"
                                        />
                                        <span class="text-zinc-500 font-normal text-sm">{{ $asset->user->name }}</span>
                                    </div>
                                    <div class="text-zinc-500 font-normal text-sm">🌟 {{ number_format($asset->reviews->avg('rating'), 1) }}</div>
                                </div>
                            </div>
                        </div>
                    </a>
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
                            <img
                                src="{{ 
                                    $review->user->profile && $review->user->profile->avatar 
                                        ? asset('storage/' . $review->user->profile->avatar) 
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) . '&background=random'
                                }}" 
                                alt="Profile" 
                                class="size-6 cursor-pointer rounded-full"
                            />
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
