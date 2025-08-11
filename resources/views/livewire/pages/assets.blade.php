<?php

use Livewire\Volt\Component;
use App\Models\Asset;

new class extends Component {
    public $assets;

    public function mount()
    {
        $this->assets = Asset::all();
    }
}; ?>

<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Lista de Assets</h1>

    <p>Olá, {{ auth()->user()->name }}!</p>

    <ul class="space-y-2">
        @foreach ($assets as $asset)
            <li class="border p-4 rounded">
                <strong>{{ $asset->title }}</strong><br>
                Tipo: {{ $asset->type }}<br>
                Preço: R$ {{ number_format($asset->price, 2, ',', '.') }}
            </li>
        @endforeach
    </ul>
</div>