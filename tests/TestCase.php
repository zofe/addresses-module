<?php

namespace App\Modules\Addresses\Tests;

use App\Modules\Addresses\AddressesServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        $this->afterApplicationCreated(fn () => $this->makeACleanSlate());
        $this->beforeApplicationDestroyed(fn () => $this->makeACleanSlate());

        parent::setUp();
    }

    public function makeACleanSlate(): void
    {
        Artisan::call('view:clear');
    }

    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            AddressesServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        $app['config']->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('session.driver', 'file');
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
