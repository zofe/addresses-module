<?php

namespace App\Modules\Addresses\Traits;


use App\Modules\Addresses\Models\Address;


trait HasAddresses
{
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function hasAnyAddresses()
    {
        return $this->addresses->count() || optional(optional($this->company)->addresses)->count();
    }

}
