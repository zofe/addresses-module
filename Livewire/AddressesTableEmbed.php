<?php

namespace App\Modules\Addresses\Livewire;

use App\Modules\Addresses\Models\Address;
use App\Modules\Auth\Traits\Authorize;
use Livewire\Attributes\On;
use Livewire\Component;
use Zofe\Rapyd\Traits\WithDataTable;
use Illuminate\Database\Eloquent\Relations\Relation;


class AddressesTableEmbed extends Component
{
    use WithDataTable, Authorize;

    public $search = '';

    public $entity;
    public $editable = false;
    public $addresses;
    public $address;

    public function booted()
    {
        $this->authorize('admin|edit addresses');
    }

    public function mount(string $addressableType, string $addressableId, $editable = false)
    {
        $this->sortField = 'id';
        $modelClass = Relation::getMorphedModel($addressableType) ?? $addressableType;
        if (!$modelClass) {
            abort(404, "Invalid addressable type");
        }
        $this->entity = $modelClass::findOrFail($addressableId);
        $this->editable = $editable;

        $this->refreshAddresses();
    }

    #[On('savedAddress')]
    public function refreshAddresses()
    {
        $this->addresses = $this->entity->addresses()->get();
    }

    #[On('editAddress')]
    public function editAddress($addressId = null, $addressableType = null, $addressableId = null)
    {

        if ($addressId) {
            $this->address = Address::find($addressId) ?: new Address;

        } else {
            $this->address = new Address;

            if ($addressableType && $addressableId) {

                $this->address->addressable_type = $addressableType;
                $this->address->addressable_id = $addressableId;
            }
        }

        $this->dispatch('show-modal',['editAddress']);
    }

    public function save()
    {
        $this->validate([
            'address.address' => 'required|string|max:255',
        ]);
        $this->address->save();
        $this->dispatch('hide-modals');
        $this->dispatch('savedAddress');
    }

    #[On('deleteAddress')]
    public function deleteAddress($addressId)
    {
        $this->address = Address::findOrfail($addressId);
        $this->address->delete();
        $this->dispatch('savedAddress');
    }

    public function render()
    {
        $addresses = $this->addresses;
        return view('addresses::addresses_table_embed', compact('addresses'));
    }
}
