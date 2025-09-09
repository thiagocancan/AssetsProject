<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Asset;

class AssetsList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';

    public function mount()
    {
        // Captura o termo de busca da URL
        $this->search = request('search', '');
    }

    public function render()
    {
        $query = Asset::with('user')->latest();

        if (!empty(trim($this->search))) {
            $searchTerm = trim($this->search);
            
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('type', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function($q2) use ($searchTerm) {
                      $q2->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        $assets = $query->paginate(20);

        return view('livewire.assets.assets-list', [
            'assets' => $assets,
        ])->layout('components.layouts.base', ['title' => 'Assets']);
    }
}