<div>
    <div class="bg-orange-600/90 p-8 w-screen absolute left-0 -z-30"> <h2 class="text-amber-50/0 text-2xl">Update User Profile</h2></div>
    <div class="bg-orange-600/0 py-8 mb-6">
        <h2 class="text-amber-50 text-2xl">Update User Profile</h2>
    </div>
    <form wire:submit.prevent="submit">
        @csrf
        <div class="flex justify-between divide-x">
            <div class="flex flex-col flex-1 gap-3 pr-12">
                <div>
                    <label class="" for="name">Name</label>
                    <input wire:model="name" id="name" type="text" placeholder="User name" class="px-3 py-1 w-full border-gray-300 border rounded-lg" />
                    @error('name') <p class="mt-3 rounded text-sm bg-zinc-700 text-amber-50 px-3 py-3 w-fit">⚠️ {{ $message }}</p> @enderror
                </div>
                
                <div class="">
                    <label for="bio">Bio</label>
                    <textarea wire:model="bio" id="bio" placeholder="Describe your bio" class="px-3 py-1 w-full h-48 border-gray-300 border rounded-lg"></textarea>
                    @error('bio') <p class="mt-3 rounded text-sm bg-zinc-700 text-amber-50 px-3 py-3 w-fit">⚠️ {{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="" for="location">Location</label>
                    <input wire:model="location" id="location" type="text" placeholder="Your location" class="px-3 py-1 w-full border-gray-300 border rounded-lg" />
                    @error('location') <p class="mt-3 rounded text-sm bg-zinc-700 text-amber-50 px-3 py-3 w-fit">⚠️ {{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="w-full" for="avatar">Avatar</label>
                    <input wire:model="avatar" type="file" class="px-3 py-4 w-full border-gray-300 border border-dashed rounded-lg cursor-pointer">
                    @error('avatar') <p class="mt-3 rounded text-sm bg-zinc-700 text-amber-50 px-3 py-3 w-fit">⚠️ {{ $message }}</p> @enderror

                    <div class="mt-4">
                        @if ($avatar)
                            {{-- Preview do upload --}}
                            <img src="{{ $avatar->temporaryUrl() }}" class="w-48 h-48 object-cover rounded">
                        @elseif ($currentAvatar)
                            {{-- Avatar existente --}}
                            <img src="{{ asset('storage/'.$currentAvatar) }}" class="w-48 h-48 object-cover rounded">
                        @else
                            {{-- Avatar padrão --}}
                            <img src="{{ asset('images/default-avatar.png') }}" class="w-48 h-48 object-cover rounded">
                        @endif
                    </div>
                </div>
                <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-md w-fit cursor-pointer">
                    Submit
                </button>
            </div>
        </div>
    </form>
</div>
