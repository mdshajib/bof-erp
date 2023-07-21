<div>
    @section('page-title')
        {{ __('Manage Contact') }}
    @endsection


    @section('header')
        <x-common.header title="{{ __('Manage Contact') }}">
            <li class="breadcrumb-item">
                <a href="javascript: void(0);">{{ __('CRM') }}</a>
            </li>
            <li class="breadcrumb-item active">{{ __('Contact Management') }}</li>
        </x-common.header>
    @endsection

    <x-action-box>
        <x-slot name="left">
            <button wire:click="openNewContactModal()" type="button" class="btn waves-effect btn-primary">
                <i class="fa fa-plus me-2"></i> {{ __('New Contact') }}
            </button>
            @include('livewire.c-r-m._add_update_contact')

        </x-slot>
        <x-slot name="right">
            <div class="d-flex justify-content-between">
                <x-form.select id="perPage" wire:model="perPage">
                    <option value="5"> 5 </option>
                    <option value="10"> 10 </option>
                    <option value="50"> 50 </option>
                    <option value="100"> 100 </option>
                </x-form.select>

                <div class="ms-2">
                    <button
                        class="btn btn-primary"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasFilter"
                        aria-controls="offcanvasFilter">
                        <i class="fa fa-filter pe-2"></i> {{ __('Search') }}
                    </button>
                    <x-offcanvas id="offcanvasFilter" size="sm" title="{{ __('Search') }}">
                        <form>
                            <x-form.input id="txt_name_filter" wire:model.defer="filter.name" placeholder="{{ __('Name') }}" />
                            <x-form.input id="txt_name_filter" wire:model.defer="filter.phone" placeholder="{{ __('Phone') }}" />
                            <button type="submit" wire:click.prevent="search" class="btn btn-primary">{{ __('Search') }}</button>
                            <button type="button" wire:click.prevent="resetSearch" class="btn btn-link">{{ __('Reset') }}</button>
                        </form>
                    </x-offcanvas>
                </div>
            </div>

        </x-slot>

    </x-action-box>

    <x-table.table>
        <x-slot name="head">
            <tr>
                <x-table.th>{{__('Name')}}</x-table.th>
                <x-table.th>{{__('Phone')}}</x-table.th>
                <x-table.th>{{__('Email')}}</x-table.th>
                <x-table.th>{{__('Address')}}</x-table.th>
                <x-table.th style="width: 90px">{{__('Action')}}</x-table.th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @forelse($contacts as $contact)
                <tr>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->phone }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->address }}</td>
                    <td>
                        <button type="button"  wire:click="openEditContactModal({{ $contact->id }})"  class="btn btn-secondary btn-sm"> <i class="fa fa-edit fa-color-primary"></i> </button>
                        <a wire:click="UserconfirmDelete({{ $contact->id }})" class="btn btn-primary btn-sm"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No Records Found!</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table.table>
    <div class="row">
        <div class="col-sm-12 col-md-5">{{ pagination_stats_text($contacts) }} </div>
        <div class="col-sm-12 col-md-7">{{ $contacts->links() }}</div>
    </div>
    <x-notify/>
</div>
