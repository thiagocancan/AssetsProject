<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Asset;

class AssetsList extends Component
{
    public $assets;

    public function mount()
    {
        $this->assets = Asset::latest()->with('user')->get() ?? collect([]);
    }

    public function render()
    {
        return view('livewire.assets.assets-list', [
            'assets' => $this->assets,
        ]) ->layout('components.layouts.base', ['title' => 'Assets']);
    }
}