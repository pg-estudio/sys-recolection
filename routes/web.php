<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::redirect('/', 'dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', App\Livewire\Dashboard::class)->name('dashboard');
    
    // Rutas de recolección
    Route::prefix('recolection')->name('recolection.')->group(function () {
        Route::get('requests', App\Livewire\Recolection\Requests::class)->name('requests');
        Route::get('routes', App\Livewire\Recolection\Routes::class)->name('routes');
    });

    // Rutas de recompensas
    Route::get('rewards', App\Livewire\Rewards::class)->name('rewards');

    // Rutas de administración
    Route::prefix('admin')->group(function () {
        Route::get('/users', App\Livewire\Admin\UserList::class)->name('admin.users');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

require __DIR__ . '/auth.php';
