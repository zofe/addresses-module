<?php

namespace App\Modules\Addresses\Tests\Feature;

use App\Modules\Addresses\Models\Address;
use App\Modules\Addresses\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

class AddressesModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_addresses_table_exists_after_migration(): void
    {
        $this->assertTrue(Schema::hasTable('addresses'));
    }

    public function test_address_model_can_be_created(): void
    {
        $address = Address::create([
            'address'      => 'Via Roma 1',
            'city'         => 'Milano',
            'zipcode'      => '20100',
            'country_code' => 'IT',
        ]);

        $this->assertDatabaseHas('addresses', ['city' => 'Milano']);
        $this->assertNotNull($address->id);
    }

    public function test_address_uses_uuid_primary_key(): void
    {
        $address = Address::create([
            'address' => 'Via Verdi 5',
            'city'    => 'Roma',
            'zipcode' => '00100',
        ]);

        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/',
            $address->id
        );
    }

    public function test_addresses_config_is_merged(): void
    {
        $this->assertIsArray(config('addresses'));
    }

    public function test_address_view_namespace_is_registered(): void
    {
        $finder = app('view')->getFinder();
        $hints = $finder->getHints();
        $this->assertArrayHasKey('addresses', $hints);
    }
}
