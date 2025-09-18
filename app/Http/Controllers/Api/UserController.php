<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display the authenticated user's profile
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Display the profile of a user by ID
     */
    public function show($id)
    {
        $user = User::with('profile')->find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user, 200);
    }

    /**
     * Update user profile information
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'string|max:255',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location' => 'nullable|string|max:100',
            'is_admin' => 'boolean',
        ]);

        $user = $request->user();

        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        $profile = $user->profile ?? $user->profile()->create([]);

        if ($request->filled('bio')) {
            $profile->bio = $request->bio;
        }
        if ($request->filled('avatar')) {
            $profile->avatar = $request->avatar;
        }
        if ($request->filled('location')) {
            $profile->location = $request->location;
        }
        if ($request->filled('is_admin')) {
            $user->is_admin = $request->is_admin;
        }

        $user->save();
        $profile->save();

        return response()->json([
            'message' => 'Profile updated successfully',
        ], 200);
    }
}
