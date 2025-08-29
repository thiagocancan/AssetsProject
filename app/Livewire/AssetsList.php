<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Asset;

class AssetsList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        return view('livewire.assets.assets-list', [
            'assets' => Asset::latest()->with('user')->paginate(20),
        ])->layout('components.layouts.base', ['title' => 'Assets']);
    }
}
