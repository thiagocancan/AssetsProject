<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\Asset;
use App\Models\Review;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AssetPage extends Component
{

    public $asset;
    public $reviews;
    public $size;
    public $successMessage;
    Public $errorMessage;

    public function mount()
    {
        $this->asset = Asset::with(['user.profile', 'reviews'])->find(request()->route('asset'));
        $this->reviews = Review::where('asset_id', $this->asset->id)
            ->where('status', 'approved')
            ->latest()
            ->get();

        if (Str::startsWith(Storage::mimeType($this->asset->preview_path), 'image')) {
            $this->asset->showType = 'img';
        } else {
            $this->asset->showType = 'vid';
        }

        $disk = $this->asset->storage_disk;

        if (Storage::disk($disk)->exists($this->asset->file_path)) {
            $bytes = Storage::disk($disk)->size($this->asset->file_path);
            $this->size = $this->formatBytes($bytes);
        } else {
            $this->size = 'unavailable';
        }
        
    }

    public function render()
    {
        return view('livewire.assets.asset-page') ->layout('components.layouts.base', ['title' => 'Asset']);
    }

    public function download($assetId)
    {
        $asset = Asset::with('user')->findOrFail($assetId);
        
        if (!auth()->check()) {
            return $this->redirectRoute('login');
        }

        try {
            $this->authorize('download', $asset);

            return Storage::disk($asset->storage_disk)->download($asset->file_path);

        } catch (AuthorizationException $e) {
            $cart = session()->get('cart', []);

            if (isset($cart[$assetId])) {
                $this->successMessage = "item already in your cart";
            } else {
                $cart[$assetId] = [
                    "title" => $asset->title,
                    "price" => $asset->price,
                    "preview" => $asset->preview_path,
                    "creator" => $asset->user->name,
                ];
                $this->successMessage = "item added in your cart";
            }

            session()->put('cart', $cart);
        }
    }

    function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
