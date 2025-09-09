<div>
    <div class="bg-orange-600/90 flex font-medium items-center mb-6">
        <img class="w-[400px]" src="https://images.squarespace-cdn.com/content/v1/5f9f625ebb288273ba51c6ec/1718195915279-M6B4JURYO43IZR77CKNH/The+Secret+Russian+KGB+Book+of+Alien+Races.png?format=2500w" alt="">
        <p class="text-amber-50 text-2xl m-12 font-light">Get the best files for creations, 3D printing, content and more.</p>
    </div>
    @if(!empty(trim($search)))
        <div class="mb-4 text-sm text-gray-600 bg-blue-50 p-3 rounded mt-6">
            <span class="font-medium">Searching for:</span> "{{ $search }}" 
            <span class="text-gray-500">- {{ $assets->total() }} Resut(s) found</span>
            <button 
                wire:click="$set('search', '')" 
                class="ml-2 text-orange-600/90 hover:text-orange-700 cursor-pointer"
            >
                ✕ Clean search
            </button>
        </div>
    @endif

    <!-- Lista de assets -->
    <div class="grid grid-cols-4 gap-6">
        @forelse($assets as $asset)
            <div class="shadow-md">
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
                <div class="p-4 bg-white dark:bg-gray-800 flex flex-col gap-2 h-50">
                    <h3 class="text-lg font-semibold">{{ $asset->title }}</h3>
                    <p class="text-zinc-500 font-normal text-sm truncate">{{ $asset->description }}</p>
                    <div class="flex items-center justify-between text-zinc-500 font-normal text-sm">
                        <div class="flex items-center gap-2">
                            <img class="w-7 h-7 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($asset->user->name) }}&background=random" alt="">
                            <span>{{ $asset->user->name }}</span>
                        </div>
                        <div>🌟 {{ number_format($asset->reviews->avg('rating'), 1) }}</div>
                    </div>
                    <div class="flex gap-2 mt-auto">
                        <a class="text-sm text-amber-50 bg-orange-600/90 py-1 px-3" href="{{ route('assets.asset-page', $asset->id) }}">Details</a>
                        <button class="py-1 px-3 border">♥</button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 text-center py-8">
                @if(!empty(trim($search)))
                    <p class="text-gray-500">No asset found for "{{ $search }}"</p>
                @else
                    <p class="text-gray-500">No asset found</p>
                @endif
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $assets->links() }}
    </div>
</div>