<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Asset;

class AssetController extends Controller
{
    /**
     * Display all assets.
     */
    public function index()
    {
        $assets = Asset::latest()->get();

        return response()->json([
            'Assets' => $assets,
        ], 200);
    }

    /**
     * Display user assets.
     */
    public function myAssets(Request $request)
    {
        $user = $request->user();

        $assets = Asset::where('user_id', $user->id)->latest()->get();

        return response()->json([
            'My Assets'=> $assets,
        ], 200);
    }

    /**
     * Create new asset.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:image,video,3d_model',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,obj,fbx|max:10240',
            'imagePreview' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,avi,mov|max:5120',
        ]);

        $this->authorize('create', Asset::class);

        $disk = $validated['price'] > 0 ? 'private' : 'public';

        if($validated['price'] === null) {
            $validated['price'] = 0;
        }

        $path = $request->file('file')->store('assets', $disk);
        $previewPath = $request->file('imagePreview')->store('assets/previewPath', 'public');

        $asset = Asset::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'category' => $validated['category'],
            'file_path' => $path,
            'preview_path' => $previewPath,
            'format' => $request->file('file')->getClientOriginalExtension(),
            'price' => $validated['price'],
            'storage_disk' => $disk,
        ]);

        return response()->json([
            'message' => 'Asset created successfully.',
            'asset' => $asset
        ], 201);
    }

    public function download(Asset $asset)
    {

        if (!$asset) {
            return response()->json(['error' => 'Asset not found'], 404);
        }

        $this->authorize('download', $asset);

        return Storage::disk($asset->storage_disk)->download($asset->file_path);
    }
    
    /**
     * Display the specified asset.
     */
    public function show($id)
    {
        $asset = Asset::with('reviews')->where('id', $id)->get();

        return response()->json([
            'Asset'=> $asset,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:image,video,3d_model',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,obj,fbx|max:10240',
        ]);

        $asset = Asset::findOrFail($id);

        $this->authorize('update', $asset);

        // Define o disco de acordo com o preço
        $disk = $validated['price'] > 0 ? 'private' : 'public';

        // Se o disco mudou, mover o arquivo existente
        if ($disk !== $asset->storage_disk && $asset->file_path) {
            if (Storage::disk($asset->storage_disk)->exists($asset->file_path)) {
                $fileContent = Storage::disk($asset->storage_disk)->get($asset->file_path);
                Storage::disk($disk)->put($asset->file_path, $fileContent);
                Storage::disk($asset->storage_disk)->delete($asset->file_path);
            }
            $validated['storage_disk'] = $disk;
        }

        // Se um novo arquivo foi enviado
        if ($request->hasFile('file')) {
            if ($asset->file_path && Storage::disk($asset->storage_disk)->exists($asset->file_path)) {
                Storage::disk($asset->storage_disk)->delete($asset->file_path);
            }

            $path = $request->file('file')->store('assets', $disk);

            $validated['file_path'] = $path;
            $validated['format'] = $request->file('file')->getClientOriginalExtension();
            $validated['storage_disk'] = $disk;
            $validated['preview_path'] = ($validated['type'] === 'image') ? $path : null;

        } else {
            // Atualiza o disco mesmo sem upload novo
            $validated['storage_disk'] = $disk;

            // Ajusta preview mesmo sem novo arquivo
            if ($validated['type'] === 'image' && $asset->file_path) {
                $validated['preview_path'] = $asset->file_path;
            } else {
                $validated['preview_path'] = null;
            }

            unset($validated['file']);
        }

        // Atualiza os campos sem risco de MassAssignment
        $asset->forceFill($validated)->save();

        return response()->json([
            'message' => 'Asset updated successfully.',
            'asset' => $asset,
        ], 200);
    }

    /**
     * Remove the specified asset from storage.
     */
    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);

        $this->authorize('delete', $asset);

        $asset->delete();

        return response()->json([
            'message' => 'Asset deleted successfully.'
        ], 200);
    }
}
