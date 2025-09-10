<div>
    @if ($successMessage)
        <div wire:poll.3s="$set('successMessage', null)" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-green-300/30 p-6 rounded shadow">
            {{ $successMessage }}
        </div>
    @endif
    <h1 class="text-orange-600/90 font-bold text-3xl mt-6">{{ $asset->title }}</h1>

    <div class="flex space-x-6 mt-3">
        <img class="w-[600px] h-[600px] pointer-events-none select-none" src="{{ asset('storage/' . $asset->preview_path) }}" alt="">
        
        <div class="w-full flex flex-col justify-between">
            <p class="text-zinc-500 font-normal whitespace-pre-line">{{ $asset->description }}</p>

            <div>
                <div flex class="flex my-6 text-zinc-500 font-normal text-sm space-x-3">
                    <p>
                        Reviews: {{ number_format($asset->reviews->avg('rating'), 1) }}
                        @for ($i = 0; $i < floor($asset->reviews->avg('rating')); $i++)
                            ⭐
                        @endfor
                        ({{ $asset->reviews->count() }})
                    </p>
                    <p>Views: 1.5k</p>
                </div>
                <div class="flex items-center">
                    <button wire:click="download({{ $asset->id }})" class="bg-orange-600/90 transition delay-50 duration-100 hover:-translate-y-1 hover:bg-orange-500/90 px-6 py-2 w-full text-amber-50 cursor-pointer">Download</button>
                    @if($asset->price > 0)
                        <p class="bg-orange-100 px-6 py-2 text-green-600">${{ $asset->price }}</p>
                    @else
                        <p class="bg-green-100 px-6 py-2 text-green-600">Free</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <dl class="flex shadow-md bg-zinc-100 p-7 mt-3 justify-around">
        <a href="{{ route('profile.profile-page', $asset->user_id) }}">
            <div class="flex space-x-3 items-center">
                <img
                    src="{{ 
                        $asset->user->profile && $asset->user->profile->avatar 
                            ? asset('storage/' . $asset->user->profile->avatar) 
                            : 'https://ui-avatars.com/api/?name=' . urlencode($asset->user->name) . '&background=random'
                    }}" 
                    alt="Profile" 
                    class="size-6 cursor-pointer rounded-full"
                />
                <div class="text-sm">
                    <h3 class="font-semibold text-zinc-700">{{ $asset->user->name }}</h3>
                    <h2 class="text-zinc-500">{{ $asset->user->profile->bio }}</h2>
                </div>
            </div>
        </a>
        <div>
    
            <div class="flex space-x-6 space-y-6 text-sm">    
                <div class="flex space-x-1">
                    <dt class="font-medium">Category:</dt>
                    <dd class="text-zinc-500">{{ $asset->category }}</dd>
                </div>

                <div class="flex space-x-1">
                    <dt class="font-medium">Type:</dt>
                    <dd class="text-zinc-500">{{ $asset->type }}</dd>
                </div>
                
                <div class="flex space-x-1">
                    <dt class="font-medium">Format:</dt>
                    <dd class="text-zinc-500">.{{ $asset->format }}</dd>
                </div>

            </div>

            <div class="flex gap-5">     
                <div class="flex text-sm">
                    <div class="flex space-x-1">
                        <dt class="font-medium">Size:</dt>
                        <dd class="text-zinc-500">{{ $size }}</dd>
                    </div>
                </div>

                <div class="flex text-sm">
                    <div class="flex space-x-1">
                        <dt class="font-medium">Create at:</dt>
                        <dd class="text-zinc-500">{{ $asset->created_at}}</dd>
                    </div>
                </div>
            </div>
        
        </div>
    </dl>

    <div class="mt-12">
        <h2 class="text-2xl">Reviews</h2>
        <div class="mt-12">
            @foreach ($reviews as $review)
                <div class="flex items-center space-x-3 pb-4 mb-4 border-b border-gray-300">
                    <img
                        src="{{ 
                            $review->user->profile && $review->user->profile->avatar 
                                ? asset('storage/' . $review->user->profile->avatar) 
                                : 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) . '&background=random'
                        }}" 
                        alt="Profile" 
                        class="size-6 cursor-pointer rounded-full"
                    />
                    <div class="space-y-3 w-full">
                        <div class="flex justify-between">
                            <div class="flex items-center space-x-3">
                                <h3 class="font-semibold text-sm">{{ $review->user->name }}</h3>
                                <p>
                                    @for ($i = 0; $i < $review->rating; $i++)
                                        ⭐
                                    @endfor
                                </p>
                            </div>
                            <p class="text-sm text-zinc-500">{{ $asset->created_at->diffForHumans() }}</p>
                        </div>
                        <p class="text-sm text-zinc-500">{{ $review->comment }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
