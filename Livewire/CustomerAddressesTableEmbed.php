<?php

namespace App\Modules\Addresses\Livewire;



class CustomerAddressesTableEmbed extends AddressesTableEmbed
{

    public function booted()
    {
        $this->authorize('admin|operator|edit own addresses');// auth()->user());
    }

}
