<div>
    @slot('buttons')
        <x-rpd::button
            label="Add Address"
            class="btn btn-outline-primary"
            color="outline-primary"
            click="$dispatch('editAddress', {addressableType: '{{ $entity->getMorphClass() }}', addressableId: '{{ $entity->id }}'})"
        />
    @endslot

    @if($addresses)
    <ul class="list-group list-group-flush ">
        @foreach($addresses as $address)
            <li class="list-group-item text-body p-1 d-flex justify-content-between align-items-start">
                {{ $address->address }}
                {{ $address->street_number }},
                {{ $address->zipcode }}
                {{ $address->city }}
                ({{ $address->province }}),
                {{ $address->region }} -
                {{ $address->country }}
                ({{ $address->country_code }})

                @if($editable)
                    <div class="text-nowrap small">
                        <x-rpd::icon name="edit" click="$dispatch('editAddress',{addressId: '{{$address->id}}'})" />
                        @if($addresses->count() > 1)
                            <x-rpd::icon name="trash-alt" click="$dispatch('deleteAddress',{addressId: '{{$address->id}}'})" confirm="delete address {{ $address->address }}?"  />
                        @endif
                    </div>
                @endif
            </li>
        @endforeach

    </ul>
    @endif


        <x-rpd::modal
            name="editAddress"
            title="Edit Address"
            action="save"
        >
            <div>
                <x-rpd::input inline model="address.address" label="Address" />
                <x-rpd::input inline model="address.city" label="City" />
                <x-rpd::input inline model="address.zipcode" label="Zipcode" />
            </div>
        </x-rpd::modal>


{{--    <livewire:addresses::addresses-modal-edit-embed />--}}

</div>
