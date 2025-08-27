<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Asset;

class ProfilePage extends Component
{
    public $user;
    public $assets;

    public function mount()
    {
        $this->user = User::with('profile')->find(request()->route('user_id'));

        $this->assets = Asset::with('reviews')->where('user_id', request()->route('user_id'))->get();

    }

    public function render()
    {
        return view('livewire.profile.profile-page',[
            'user' => $this->user,
            'assets' => $this->assets,
        ]) ->layout('components.layouts.base');
    }

    public $activeTab = 'assets';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }
}
