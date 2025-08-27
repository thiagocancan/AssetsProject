<div>
    <div class="bg-orange-600/90 flex font-medium items-center mb-6">
        <img class="w-[400px]" src="https://images.squarespace-cdn.com/content/v1/5f9f625ebb288273ba51c6ec/1718195915279-M6B4JURYO43IZR77CKNH/The+Secret+Russian+KGB+Book+of+Alien+Races.png?format=2500w" alt="">
        <p class="text-white text-3xl m-12 font-light">Get the best files for creations, 3D printing, content and more.</p>
    </div>
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
                        <span class="self-end bg-orange-600/90 w-fit px-2 py-1 text-sm text-amber-50">R$ {{ number_format($asset->price, 2, ',', '.') }}</span>
                    @endif
                </div>
                <div class="p-4 bg-white dark:bg-gray-800 flex flex-col gap-2 h-50">
                    <h3 class="text-lg font-semibold">{{ $asset->title }}</h3>
                    <p class="text-zinc-500 font-normal text-sm truncate">{{ $asset->description }}</p>
                    <div class="flex items-center justify-between text-zinc-500 font-normal text-sm">
                        <div class="flex items-center gap-2">
                            <div class="flex items-center justify-center text-white text-sm w-[24px] h-[24px] rounded-full bg-orange-500">JD</div>
                            <span class="text-zinc-500 font-normal text-sm">{{ $asset->user->name }}</span>
                        </div>
                        <div class="text-zinc-500 font-normal text-sm">🌟 4.8</div>
                    </div>
                    <div class="flex gap-2 mt-auto">
                        <a class="text-sm text-zinc-100 bg-orange-600/90 py-1 px-3" href="{{ route('assets.asset-page', $asset->id) }}">Details</a>
                        <button class="py-1 px-3 border ">♥</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

