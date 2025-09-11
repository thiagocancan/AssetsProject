<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\AssetsList;
use App\Livewire\AssetPage;
use App\Livewire\ProfilePage;
use App\Livewire\UploadAssetForm;
use App\Livewire\MyCart;
use App\Livewire\OrderAsset;
use App\Livewire\UpdateUserProfile;

// Route::get('/', function () {
//     return view('assets.assets-list');
// })->name('home');

Route::get('/', AssetsList::class)
    ->name('home');

Route::get('/asset/{asset}', AssetPage::class)
->name('assets.asset-page');

Route::get('/profile/{user_id}', ProfilePage::class)
    ->name('profile.profile-page');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/upload', UploadAssetForm::class)
    ->name('assets.upload-asset-form');

    Route::get('/mycart', MyCart::class)
    ->name('mycart');

    Route::get('/updateuser', UpdateUserProfile::class)
    ->name('userupdate');

    Route::get('/orders', OrderAsset::class)
    ->name('myOrders');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
