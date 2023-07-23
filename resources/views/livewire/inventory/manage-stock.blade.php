<div>
    @section('page-title')
        Manage Inventory
    @endsection

    @section('header')
        <x-common.header title="Manage Inventory">
            <li class="breadcrumb-item">
                <a href="javascript: void(0);">Inventory Management</a>
            </li>
            <li class="breadcrumb-item active">Stock</li>
        </x-common.header>
    @endsection

    <x-action-box>
        <x-slot name="left">
            <div class="row">
                <div class="col-auto">
                    <a target="_blank" href="{{route('inventory.stockin')}}" class="btn waves-effect btn-primary">
                        <i class="fa fa-plus me-2"></i> Add Stock
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

                        <x-form.input id="txt_title_filter" wire:model.defer="filter.product" placeholder="{{ __('Product') }}" />

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
                <x-table.th>{{ __('Product') }}</x-table.th>
                <x-table.th>{{ __('Purchase Order') }}</x-table.th>
                <x-table.th>{{ __('Loan') }}</x-table.th>
                <x-table.th>{{ __('Stock Quantity') }}</x-table.th>
                <x-table.th>{{ __('COGS Price') }}</x-table.th>
                <x-table.th>{{ __('Selling Price') }}</x-table.th>
                <x-table.th>{{ __('SKU') }}</x-table.th>
                <x-table.th>{{ __('Supplier') }}</x-table.th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @php $i=0; @endphp
            @forelse ($stocks as $stock)
                <tr>
                    <td> {{ $stock->variation?->variation_name }} </td>
                    <td>
                        <a href="{{ route('purchase.view', ['purchase_id' => $stock->sku?->purchase_order_id]) }}">
                            PR#{{ str_pad($stock->sku?->purchase_order_id, 6, '0', STR_PAD_LEFT) }}
                        </a>
                    </td>
                    <td>
                        @if($stock->sku->loan)
                            Yes
                        @else
                            -
                        @endif
                    </td>
                    <td> {{ $stock->quantity }} </td>
                    <td> {{ $stock->quantity * $stock->sku?->cogs_price }} </td>
                    <td> {{ $stock->quantity * $stock->sku?->selling_price }} </td>
                    <td>
                        <div class="ms-2">
                            {!! DNS1D::getBarcodeHTML($stock->sku_id, 'C128',1,30,'black') !!}
                        </div>
                        <div>
                            <span style="letter-spacing: 0.12rem;">{{ $stock->sku_id }}</span>
                        </div>
                    </td>
                    <td>{{ $stock?->supplier?->name }}, {{ $stock?->supplier?->address }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">{{ __('No Record Found!') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table.table>
    <div class="row">
        <div class="col-sm-12 col-md-5"><?php echo pagination_stats_text($stocks); ?></div>
        <div class="col-sm-12 col-md-7">{{ $stocks->links() }}</div>
    </div>
    @include('livewire.x-loading')
    <x-notify/>
</div>
