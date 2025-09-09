<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Asset;
use Livewire\WithFileUploads;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UploadAssetForm extends Component
{
    use WithFileUploads, AuthorizesRequests;

    public $title;
    public $description;
    public $details;
    public $included;
    public $type;
    public $category;
    public $price;
    public $file;
    public $imagePreview;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'type' => 'required|in:image,video,3d_model',
        'category' => 'required|string|max:100',
        'price' => 'nullable|numeric|min:0',
        'file' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,obj,fbx|max:10240',
        'imagePreview' => 'required|file|mimes:jpeg,png,jpg|max:10240',
        'details' => 'nullable|string',
        'included' => 'nullable|string',
    ];

    public function submit()
    {
        $validated = $this->validate();

        $this->authorize('create', Asset::class);

        $disk = $validated['price'] > 0 ? 'private' : 'public';

        if($validated['price'] === null) {
            $validated['price'] = 0;
        }

        $path = $this->file->store('assets', $disk);
        $previewPath = $this->imagePreview->store('assets/previewPath', 'public');

        // $previewPath = null;
        // if ($validated['type'] === 'image') {
        //     $previewPath = $path;
        // }

        $combinedText = "✅ Description\n" . ($validated['description'] ?? '-') . "\n\n"
            . "⚙️ Technical Details\n" . ($validated['details'] ?? '-') . "\n\n"
            . "📦 What’s Included\n" . ($validated['included'] ?? '-');

        Asset::create([
            'user_id'      => auth()->id(),
            'title'        => $validated['title'],
            'description'  => $combinedText,
            'type'         => $validated['type'],
            'category'     => $validated['category'],
            'price'        => $validated['price'],
            'preview_path' => $previewPath,
            'format'       => $this->file->getClientOriginalExtension(),
            'storage_disk' => $disk,
            'file_path'    => $path,
        ]);

        session()->flash('success', 'Asset created with success.');

        $this->reset();

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.assets.upload-asset-form')->layout('components.layouts.base');
    }
}
