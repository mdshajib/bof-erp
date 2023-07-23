<form wire:submit.prevent='submit'>
    <x-modal
        :has-button="false"
        modal-id="modalNewSupplier"
        on="openNewSupplierModal"
        title="{{ $supplier_id ? 'Edit Supplier' : 'Add New Supplier' }}"
     >

         <x-form.input
             required="required"
            type="text"
            wire:model.defer='supplier.name'
            id="name"
            label="Name"
            placeholder="Supplier Name"
            :error="$errors->first('supplier.name')"
        />

        <x-form.input
            type="text"
            wire:model.defer='supplier.phone'
            id="txt_phone"
            label="Phone"
            placeholder="Phone"
            :error="$errors->first('supplier.phone')"
        />

        <x-form.input
            required="required"
            type="text"
            wire:model.defer='supplier.address'
            id="txt_address"
            label="Address"
            placeholder="Address"
            :error="$errors->first('supplier.address')"
        />
        <x-form.check wire:model='supplier.active' id="txt_active" label="Active"/>
     <x-slot name="footer">
         <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
             <div wire:loading>
                 <i class="fas fa-spin fa-spinner mr-2"></i>
             </div>
             Save
         </button>
     </x-slot>
    </x-modal>
</form>
