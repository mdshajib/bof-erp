<form wire:submit.prevent='submit'>
    <x-modal
        :has-button="false"
        modal-id="modalNewSupplier"
        on="openNewSupplierModal"
        title="{{ $supplier_id ? 'Edit Supplier' : 'Add New Supplier' }}"
     >

         <x-form.input
            type="text"
            wire:model.defer='name'
            id="name"
            label="Name"
            placeholder="Supplier Name"
            :error="$errors->first('name')"
        />

        <x-form.input
            type="text"
            wire:model.defer='phone'
            id="txt_phone"
            label="Phone"
            placeholder="Phone"
            :error="$errors->first('phone')"
        />

        <x-form.input
            type="text"
            wire:model.defer='address'
            id="txt_address"
            label="Address"
            placeholder="Address"
            :error="$errors->first('address')"
        />
        <x-form.check wire:model='active' id="txt_active" label="Active"/>
     <x-slot name="footer">
         <button type="submit" class="btn btn-primary">Save</button>
     </x-slot>
    </x-modal>
</form>
