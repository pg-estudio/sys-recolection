<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadViewComponentsAs('', [
            \App\View\Components\InputError::class,
        ]);

        $this->loadViewComponentsAs('flux', [
            \App\View\Components\Flux\Input::class,
            \App\View\Components\Flux\Label::class,
        ]);
    }
}
