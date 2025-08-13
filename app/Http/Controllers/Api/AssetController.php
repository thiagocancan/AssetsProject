<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
            'file_path' => 'required|string',
            'preview_path' => 'nullable|url',
            'format' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
        ]);

        $asset = Asset::create(array_merge($validated, [
            'user_id' => auth()->id(),
        ]));

        return response()->json([
            'message' => 'Asset created successfully.',
            'asset' => $asset
        ], 201);
    }
    
    /**
     * Display the specified asset.
     */
    public function show($id)
    {
        $asset = Asset::where('id', $id)->get();

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
            'file_path' => 'required|string',
            'preview_path' => 'nullable|url',
            'format' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
        ]);

        $asset = Asset::findOrFail($id);

        if ($asset->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $asset->update($validated);

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

        // Se quiser verificar se o asset pertence ao usuário logado
        if ($asset->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $asset->delete();

        return response()->json([
            'message' => 'Asset deleted successfully.'
        ], 200);
    }
}
