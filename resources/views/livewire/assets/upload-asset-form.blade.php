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
                    <input wire:model="file" id="file" type="file" class="px-3 py-4 w-full border-gray-300 border border-dashed rounded-lg cursor-pointer">
                    @error('file') <p class="mt-3 rounded text-sm bg-zinc-700 text-amber-50 px-3 py-3 w-fit">⚠️ {{ $message }}</p> @enderror

                    <div wire:loading wire:target="file" class="text-blue-500 mb-4">
                        <div role="status">
                            <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                            <span>Loading...</span>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="w-full" for="imagePreview">Image Preview</label>
                    <input wire:model.defer="imagePreview" id="imagePreview" type="file" class="px-3 py-4 w-full border-gray-300 border border-dashed rounded-lg cursor-pointer">
                    @error('imagePreview') <p class="mt-3 rounded text-sm bg-zinc-700 text-amber-50 px-3 py-3 w-fit">⚠️ {{ $message }}</p> @enderror

                    <div wire:loading wire:target="imagePreview" class="text-blue-500 mb-4 flex">
                        <div role="status">
                            <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                            <span>Loading...</span>
                        </div>       
                    </div>

                    @if ($imagePreview)
                        <div class="mt-4">
                            @if (Str::startsWith($imagePreview->getMimeType(), 'image'))
                                <img src="{{ $imagePreview->temporaryUrl() }}" class="w-48 h-48 object-cover rounded">
                            @else
                                <video autoplay class="w-48 h-48 object-cover rounded">
                                    <source src="{{ $imagePreview->temporaryUrl() }}" type="{{ $imagePreview->getMimeType() }}">
                                    Seu navegador não suporta o vídeo.
                                </video>
                            @endif
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
