<div>
    @section('page-title')
        Transaction List
    @endsection

    @section('header')
        <x-common.header title="Transaction List">
            <li class="breadcrumb-item">
                <a href="javascript: void(0);">Inventory Management</a>
            </li>
            <li class="breadcrumb-item active">All Transaction</li>
        </x-common.header>
    @endsection

    <x-action-box>
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

                        <x-form.input id="txt_title_filter" wire:model.defer="filter.variation_name" placeholder="{{ __('Product') }}" />
                        <x-form.input id="txt_title_filter" wire:model.defer="filter.sku" placeholder="{{ __('SKU') }}" />
                        <x-form.input id="txt_title_filter" wire:model.defer="filter.purchase_id" placeholder="{{ __('Purchase No') }}" />

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
                <x-table.th width="15%" sortable :direction="$sorts['variation_name'] ?? null" wire:click="sortBy('variation_name')">{{ __('Product') }}</x-table.th>
                <x-table.th>{{ __('SKU') }}</x-table.th>
                <x-table.th>{{ __('Purchase Order') }}</x-table.th>
                <x-table.th>{{ __('Quantity') }}</x-table.th>
                <x-table.th>{{ __('Total COGS Price') }} | {{ __('COGS Price') }}</x-table.th>
                <x-table.th>{{ __('Total Selling Price') }} | {{ __('Selling Price') }}</x-table.th>
                <x-table.th>{{ __('Type') }}</x-table.th>
                <x-table.th>{{ __('Adjust') }}</x-table.th>
                <x-table.th>{{ __('Note') }}</x-table.th>
                <x-table.th>{{ __('Generated By') }}</x-table.th>
                <x-table.th>{{ __('Date') }}</x-table.th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @php $i=0; @endphp
            @forelse ($transactions as $transaction)
                @php $i++; @endphp
                <tr wire:key='{{ $transaction->id }}'>
                    <td>
                        {{ $transaction->variation_name }}
                    </td>
                    <td> {{ $transaction->sku_id }} </td>
                    <td>
                        <a class="btn-link logo-color" href="{{ route('purchase.view', ['purchase_id' => $transaction->sku?->purchase_order_id]) }}">
                            PR#{{ str_pad($transaction->sku?->purchase_order_id, 6, '0', STR_PAD_LEFT) }}
                        </a>
                    </td>
                    <td> {{ $transaction->quantity }} </td>
                    <td> {{ $transaction->quantity * $transaction->sku?->cogs_price }} | {{  $transaction->sku?->cogs_price }}</td>
                    <td>
                        @if($transaction->type == 'out' && $transaction->is_adjust)
                            -
                        @else
                            {{ $transaction->quantity * $transaction->sku?->selling_price }} | {{ $transaction->sku?->selling_price }}
                        @endif
                    </td>
                    <td>
                        @if($transaction->type == 'in')
                            <span class="badge bg-success text-white"> {{ ucwords($transaction->type) }}</span>
                        @else
                            <span class="badge bg-danger text-white">{{ ucwords($transaction->type) }}</span>
                        @endif
                    </td>
                    <td>
                        @if($transaction->is_adjust)
                            <span class="badge bg-danger text-white">Yes</span>
                        @else
                            <span class="badge bg-success text-white">No</span>
                        @endif
                    </td>
                    <td> {{ $transaction->note }} </td>
                    <td> {{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</td>
                    <td> {{ $transaction->created_at->format('Y-m-d h:m A') }} </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">{{ __('No Record Found!') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table.table>
    <div class="row">
        <div class="col-sm-12 col-md-5">{{ pagination_stats_text($transactions) }}</div>
        <div class="col-sm-12 col-md-7">{{ $transactions->links() }}</div>
    </div>
    <x-notify/>
</div>
