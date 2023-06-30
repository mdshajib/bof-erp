<div>
    @section('page-title')
        Manage Purchase
    @endsection

    @section('header')
        <x-common.header title="Manage Purchase">
            <li class="breadcrumb-item">
                <a href="javascript: void(0);">Purchase Management</a>
            </li>
            <li class="breadcrumb-item active">All Purchase Order</li>
        </x-common.header>
    @endsection

    <x-action-box>
        <x-slot name="left">
            <div class="row">
                <div class="col-auto">
                    <a target="_blank" href="{{route('purchase.create')}}" class="btn waves-effect btn-primary">
                        <i class="fa fa-plus me-2"></i> Add New Purchase Order
                    </a>
                </div>
            </div>
        </x-slot>
        <x-slot name="right">
            <div class="d-flex justify-content-between">
                <x-form.select id="perPage" wire:model="perPage">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
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

                        <x-form.input id="txt_title_filter" wire:model.defer="filter.purchase_number" placeholder="{{ __('Purchase Number') }}" />

                        <button type="button" wire:click.prevent="search" class="btn btn-primary">Search</button>
                        <button type="button" wire:click.prevent="resetSearch" class="btn btn-link">Reset</button>

                    </x-offcanvas>
                </div>
            </div>

        </x-slot>
    </x-action-box>

    <x-table.table>
        <x-slot name="head">
            <tr>
                <x-table.th sortable :direction="$sorts['purchase_number'] ?? null" wire:click="sortBy('purchase_number')">{{ __('Purchase Number') }}</x-table.th>
                <x-table.th>{{ __('Order Date') }}</x-table.th>
                <x-table.th>{{ __('Gross Amount') }}</x-table.th>
                <x-table.th>{{ __('Generated By') }}</x-table.th>
                <x-table.th >{{ __('Action') }}</x-table.th>
                <x-table.th >{{ __('View') }}</x-table.th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @php $i=0; @endphp
            @forelse ($orders as $order)
                @php $i++; @endphp
                <tr wire:key='{{ $order->id }}'>
                    <td> {{ $order->purchase_number }} </td>
                    <td> {{ $order->order_date }} </td>
                    <td> {{ $order->gross_amount }} </td>
                    <td> {{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                    <td></td>
                    <td></td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">{{ __('No Record Found!') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table.table>
    <div class="row">
        <div class="col-sm-12 col-md-5"><?php echo pagination_stats_text($orders); ?></div>
        <div class="col-sm-12 col-md-7">{{ $orders->links() }}</div>
    </div>
{{--    @include('livewire.order._order_details')--}}
    @include('livewire.x-loading')
    <x-notify/>
</div>
