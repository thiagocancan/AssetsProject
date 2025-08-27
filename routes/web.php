<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\AssetsList;
use App\Livewire\AssetPage;

// Route::get('/', function () {
//     return view('assets.assets-list');
// })->name('home');

Route::get('/', AssetsList::class)
    ->name('home');

Route::get('/asset/{asset}', AssetPage::class)
    ->name('assets.asset-page');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
