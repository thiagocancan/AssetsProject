<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display all users.
     */
    public function index()
    {
        $users = \App\Models\User::all();

        return response()->json([
            'Users' => $users,
        ], 200);
    }

    /**
     * Delete an asset by ID.
     */
    public function deleteAsset($id)
    {
        $asset = \App\Models\Asset::findOrFail($id);
        $asset->delete();

        return response()->json([
            'message' => 'Asset deleted successfully.',
        ], 200);
    }
}
