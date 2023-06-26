<div>
    @section('page-title')
        Manage Supplier
    @endsection


    @section('header')
        <x-common.header title="Manage Supplier">
            <li class="breadcrumb-item">
                <a href="javascript: void(0);">Supplier Management</a>
            </li>
            <li class="breadcrumb-item active">Manage Supplier</li>
        </x-common.header>
    @endsection

    <x-action-box>
        <x-slot name="left">
            <button wire:click="openNewSupplierModal" type="button" class="btn waves-effect btn-primary">
                <i class="fa fa-plus me-2"></i> New Supplier
            </button>
            @include('livewire.supplier._add_update_supplier')

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
                        <i class="fa fa-filter pe-2"></i> Search
                    </button>
                    <x-offcanvas id="offcanvasFilter" size="sm" title="Search">
                        <form>
                            <x-form.input id="txt_name_filter" wire:model.defer="filter.name" placeholder="{{ __('Name') }}" />
                            <x-form.input id="txt_name_filter" wire:model.defer="filter.address" placeholder="{{ __('Address') }}" />
                            <button type="submit" wire:click.prevent="search" class="btn btn-primary">Search</button>
                            <button type="button" wire:click.prevent="resetSearch" class="btn btn-link">Reset</button>
                        </form>
                    </x-offcanvas>
                </div>
            </div>

        </x-slot>

    </x-action-box>

    <x-table.table>
        <x-slot name="head">
            <tr>
                <x-table.th>Name</x-table.th>
                <x-table.th>Phone</x-table.th>
                <x-table.th>Address</x-table.th>
                <x-table.th style="width: 98px">Status</x-table.th>
                <x-table.th style="width: 90px">Action</x-table.th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @forelse($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->phone }}</td>
                    <td>{{ $supplier->address }}</td>
                    <td>
                        @livewire('toggle-switch', ['model'=>$supplier, 'field'=>'is_active','name'=>$supplier->name], key($supplier->id))
                    </td>
                    <td>
                        <button type="button"  wire:click="openEditSupplierModal({{ $supplier->id }})"  class="btn btn-secondary btn-sm"> <i class="fa fa-edit fa-color-primary"></i> </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No Records Found!</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table.table>
    <div class="row">
        <div class="col-sm-12 col-md-5">{{ pagination_stats_text($suppliers) }} </div>
        <div class="col-sm-12 col-md-7">{{ $suppliers->links() }}</div>
    </div>
    @include('livewire.x-loading')
    <x-notify/>
</div>
