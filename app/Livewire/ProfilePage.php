<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Asset;
use App\Models\Review;

class ProfilePage extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Livewire precisa saber que existem 2 paginadores diferentes
    protected $paginationComponentNames = [
        'assets' => 'page_assets',
        'reviews' => 'page_reviews',
    ];

    public $user;
    public $assets_count;
    public $reviews_count;
    public $activeTab = 'assets';

    public function mount()
    {
        $this->user = User::with('profile')->findOrFail(request()->route('user_id'));

        $this->assets_count = Asset::where('user_id', request()->route('user_id'))->count();

        $this->reviews_count = Review::where('status', 'approved')->whereHas('asset', function ($q) {
            $q->where('user_id', $this->user->id);
        })->count();
    }

    public function render()
    {
        $assets = Asset::latest()
            ->where('user_id', $this->user->id)
            ->paginate(20, pageName: 'page_assets');

        $reviews = Review::where('status', 'approved')->latest()
            ->with('asset', 'user')
            ->whereHas('asset', fn ($q) => $q->where('user_id', $this->user->id))
            ->paginate(5, pageName: 'page_reviews');

        return view('livewire.profile.profile-page', [
            'assets' => $assets,
            'reviews' => $reviews,
        ])->layout('components.layouts.base');
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }
}
