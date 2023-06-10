<form wire:submit.prevent='submit'>
    <x-modal
        :has-button="false"
        modal-id="modalNewUser"
        on="openNewUserModal"
        title="{{ $user_id ? 'Edit User' : 'Add New User' }}"
     >

         <x-form.input
            type="text"
            wire:model.defer='first_name'
            id="txt_first_name"
            label="First Name"
            placeholder="First Name"
            :error="$errors->first('first_name')"
        />

        <x-form.input
            type="text"
            wire:model.defer='last_name'
            id="txt_last_name"
            label="Last Name"
            placeholder="Last Name"
            :error="$errors->first('last_name')"
        />
            @if (!$user_id)
            <x-form.input
                        type="email"
                        wire:model.defer='email'
                        id="txt_email"
                        label="Email"
                        placeholder="Email"
                        :error="$errors->first('email')"
                    />
            @else
            <x-form.input
                        type="email"
                        wire:model.defer='email'
                        id="txt_email"
                        label="Email"
                        placeholder="Email"
                        :error="$errors->first('email')" readonly
                    />
            @endif


        @if(!$user_id)
        <x-form.input
            type="password"
            wire:model.defer='password'
            id="txt_pasword"
            label="Password"
            placeholder="Password"
            :error="$errors->first('password')"
        />
        @endif
        @if($user_id == auth()->user()->id)

        @else
        <x-form.select wire:model.defer='role' :error="$errors->first('role')" id="txt_role" label="Role">
            <option value="">-Select Role-</option>
            @foreach($roles as $role)
            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
            @endforeach
        </x-form.select>

        <x-form.check wire:model.defer='active' id="txt_active" label="Active"/>
        @endif
     <x-slot name="footer">
         <button type="submit" class="btn btn-primary">Save</button>
     </x-slot>
    </x-modal>
</form>
