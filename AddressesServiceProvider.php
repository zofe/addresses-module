<?php

namespace App\Modules\Addresses;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AddressesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Livewire::addNamespace('addresses', null, 'App\\Modules\\Addresses\\Livewire', __DIR__ . '/Livewire');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/addresses.php', 'addresses');
    }
}
