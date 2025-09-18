<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class UpdateUserProfile extends Component
{
    use WithFileUploads;

    public $user;
    public $name;
    public $bio;
    public $avatar;
    public $location;
    public $currentAvatar;

    protected $rules = [
        'name' => 'required|string|max:255',
        'bio' => 'nullable|string|max:500',
        'avatar' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'location' => 'nullable|string|max:100',
    ];

    public function mount()
    {
        $this->user = auth()->user()->load('profile');

        $this->name = $this->user->name;
        $this->bio = $this->user->profile->bio ?? '';
        $this->location = $this->user->profile->location ?? '';
        $this->currentAvatar = $this->user->profile->avatar ?? null;
    }

    public function submit()
    {
        $validated = $this->validate();

        $this->user->name = $validated['name'];
        $this->user->save();

        $profile = $this->user->profile ?? $this->user->profile()->create([]);
        $profile->bio = $validated['bio'] ?? '';
        $profile->location = $validated['location'] ?? '';

        if ($this->avatar) {
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }

            $profile->avatar = $this->avatar->store('avatars', 'public');
            $this->currentAvatar = $profile->avatar;
        }

        $profile->save();

        session()->flash('success', 'User updated successfully.');

        return redirect()->route('profile.profile-page', $this->user->id);
    }

    public function render()
    {
        return view('livewire.profile.update-user-profile')->layout('components.layouts.base');
    }
}
