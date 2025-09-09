<div>
    <div class="flex items-center bg-zinc-600 rounded-md overflow-hidden">
        <input 
            type="text" 
            placeholder="Search assets..." 
            wire:model="search"
            wire:keydown.enter="performSearch"
            class="flex-1 px-4 py-[4px] focus:outline-none text-sm placeholder:text-sm"
        />
        <button 
            wire:click="performSearch" 
            class="px-3 cursor-pointer transition-colors"
            type="button"
        >
            🔍
        </button>
    </div>
</div>
