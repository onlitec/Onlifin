<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Livewire\Transactions\FormModal;
use Livewire\Livewire;
use App\Models\User;
use App\Observers\UserObserver;

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
        Blade::component('components.application-logo', 'application-logo');
        Livewire::component('transactions.form-modal', FormModal::class);
        User::observe(UserObserver::class);
    }
}
