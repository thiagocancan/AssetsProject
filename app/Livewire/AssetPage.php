<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Asset;
use Illuminate\Support\Facades\Storage;

class AssetPage extends Component
{
    public $asset;
    public $size;

    public function mount()
    {
        $this->asset = Asset::with(['user.profile', 'reviews'])->find(request()->route('asset'));

        $this->size = $this->asset->formatBytes(Storage::size($this->asset->file_path));
    }

    public function render()
    {
        return view('livewire.assets.asset-page', [
            'asset' => $this->asset,
            'size'  => $this->size,
        ]) ->layout('components.layouts.base', ['title' => 'Asset']);
    }

    public function download($assetId)
    {
        $asset = Asset::findOrFail($assetId);

        $this->authorize('download', $asset);

        return Storage::disk($asset->storage_disk)->download($asset->file_path);
    }
}
