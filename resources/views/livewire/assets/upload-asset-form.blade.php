<div>
    <div class="bg-orange-600/90 p-8 w-screen absolute left-0 -z-30"> <h2 class="text-amber-50/0 text-2xl">New Asset</h2></div>
    <div class="bg-orange-600/0 py-8 mb-6">
        <h2 class="text-amber-50 text-2xl">New Asset</h2>
    </div>
    <form wire:submit.prevent="submit" class="space-y-4">
        @csrf
        <div class="flex justify-between divide-x">
            <div class="flex flex-col flex-1 gap-3 pr-12">
                <div>
                    <label class="" for="title">Title</label>
                    <input wire:model="title" id="title" type="text" placeholder="Your creation Title" class="px-3 py-1 w-full border-gray-300 border rounded-lg" />
                    @error('title') <p class="mt-3 rounded text-sm bg-zinc-700 text-amber-50 px-3 py-3 w-fit">⚠️ {{ $message }}</p> @enderror
                </div>

                <div class="">
                    <label for="description">Description</label>
                    <textarea wire:model="description" id="description" placeholder="Describe your creation" class="px-3 py-1 w-full h-48 border-gray-300 border rounded-lg"></textarea>
                    @error('description') <p class="mt-3 rounded text-sm bg-zinc-700 text-amber-50 px-3 py-3 w-fit">⚠️ {{ $message }}</p> @enderror
                </div>

                <div class="">
                    <label for="details">Technical Details</label>
                    <textarea wire:model="details" id="details" placeholder="Settings and manufacturing instructions" class="px-3 py-1 w-full h-20 border-gray-300 border rounded-lg"></textarea>
                    @error('details') <p class="mt-3 rounded text-sm bg-zinc-700 text-amber-50 px-3 py-3 w-fit">⚠️ {{ $message }}</p> @enderror
                </div>

                <div class="">
                    <label for="included">What’s Included</label>
                    <textarea wire:model="included" id="included" placeholder="What files are included?" class="px-3 py-1 w-full h-20 border-gray-300 border rounded-lg"></textarea>
                    @error('included') <p class="mt-3 rounded text-sm bg-zinc-700 text-amber-50 px-3 py-3 w-fit">⚠️ {{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="type">Type</label>
                    <select class="px-3 py-1 w-full border-gray-300 border rounded-lg" wire:model="type" id="type">
                        <option value="">Select...</option>
                        <option value="3d_model">3D Model</option>
                        <option value="image">Image</option>
                        <option value="video">Video</option>
                    </select>
                    @error('type') <p class="mt-3 rounded text-sm bg-zinc-700 text-amber-50 px-3 py-3 w-fit">⚠️ {{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex flex-col flex-1 gap-3 pl-12">
                <div>
                    <label class="" for="category">Category</label>
                    <select class="px-3 py-1 w-full border-gray-300 border rounded-lg" wire:model="category" id="category">
                        <option value="">Select...</option>
                        <option value="Game">Game</option>
                        <option value="Art">Art</option>
                        <option value="Architecture">Architecture</option>
                        <option value="Car">Car</option>
                        <option value="Home">Home</option>
                        <option value="Nature">Nature</option>
                        <option value="Tools">Tools</option>
                    </select>
                    @error('category') <p class="mt-3 rounded text-sm bg-zinc-700 text-amber-50 px-3 py-3 w-fit">⚠️ {{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="price"><abbr title="With you not add a price, it will be set as free by default">Price</abbr></label>
                    <input value="0" placeholder="Free" wire:model="price" type="text" class="placeholder-green-600/60 px-3 py-1 w-full border-gray-300 border rounded-lg">
                    @error('price') <p class="mt-3 rounded text-sm bg-zinc-700 text-amber-50 px-3 py-3 w-fit">⚠️ {{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="w-full" for="file">File</label>
                    <input wire:model="file" type="file" class="px-3 py-4 w-full border-gray-300 border border-dashed rounded-lg cursor-pointer">
                    @error('file') <p class="mt-3 rounded text-sm bg-zinc-700 text-amber-50 px-3 py-3 w-fit">⚠️ {{ $message }}</p> @enderror

                    @if ($file)
                        <div class="mt-4">
                            <img src="{{ $file->temporaryUrl() }}" class="w-48 h-48 object-cover rounded">
                        </div>
                    @endif
                </div>
                <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-md w-fit cursor-pointer">
                    Submit
                </button>
            </div>

        </div>
    </form>
</div>
