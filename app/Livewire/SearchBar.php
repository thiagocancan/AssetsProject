<?php

namespace App\Livewire;

use Livewire\Component;

class SearchBar extends Component
{
    public $search = '';

    public function mount()
    {
        // Captura o termo de busca da URL se existir
        $this->search = request('search', '');
    }

    public function performSearch()
    {
        if (!empty(trim($this->search))) {
            // Redireciona para a página de assets com o termo de busca
            return redirect()->route('home', ['search' => $this->search]);
        }
    }

    public function render()
    {
        return view('livewire.search-bar');
    }
}