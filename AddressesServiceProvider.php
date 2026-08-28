<?php

namespace App\Modules\Addresses;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AddressesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Livewire::addNamespace('addresses', null, 'App\\Modules\\Addresses\\Livewire', __DIR__ . '/Livewire');
        $this->loadViewsFrom(__DIR__ . '/Livewire', 'addresses');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/addresses.php', 'addresses');
    }
}
