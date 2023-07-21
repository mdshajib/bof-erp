<form wire:submit.prevent='submit'>
    <x-modal
        :has-button="false"
        modal-id="modalNewContact"
        on="openNewContactModal"
        title="{{ $contact_id ? __('Edit Special Contact') : __('Add New Special Contact') }}"
     >

         <x-form.input
            type="text"
            wire:model.defer='contact.name'
            id="name"
            label="{{__('Name')}}"
            placeholder="{{__('Name')}}"
            :error="$errors->first('contact.name')"
        />

        <x-form.input
            type="text"
            wire:model.defer='contact.phone'
            id="txt_phone"
            label="{{__('Phone')}}"
            placeholder="{{__('Phone')}}"
            :error="$errors->first('contact.phone')"
        />
        <x-form.input
            type="text"
            wire:model.defer='contact.batch_no'
            id="txt_batch_no"
            label="{{__('Batch No')}}"
            placeholder="{{__('Batch No')}}"
            :error="$errors->first('contact.batch_no')"
        />

        <x-form.input
            type="email"
            wire:model.defer='contact.email'
            id="txt_email"
            label="{{__('Email')}}"
            placeholder="{{__('Email')}}"
            :error="$errors->first('contact.email')"
        />
        <x-form.input
            type="text"
            wire:model.defer='contact.address'
            id="txt_address"
            label="{{__('Address')}}"
            placeholder="{{__('Address')}}"
            :error="$errors->first('contact.address')"
        />
     <x-slot name="footer">
         <button type="submit" class="btn btn-primary"  wire:loading.attr="disabled">
             <div wire:loading>
                 <i class="fas fa-spin fa-spinner mr-2"></i>
             </div>
             {{ __('Save') }}
         </button>
     </x-slot>
    </x-modal>
</form>
