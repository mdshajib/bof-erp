<div>
    @section('page-title')
        Reports Yearly
    @endsection

    @section('header')
        <x-common.header title="Report Yearly">
            <li class="breadcrumb-item">
                <a href="javascript: void(0);">Sales Reports</a>
            </li>
            <li class="breadcrumb-item active">Yearly</li>
        </x-common.header>
    @endsection
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-1">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                <div class="mb-1">
                                    <label for="get_selected_date">Year</label>
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend pointer">
                                            <span style="border-radius: 0px; cursor: pointer;" class="input-group-text"  wire:click.prevent="addedMinus"> <i class="mdi mdi-chevron-left align-middle font-size-14"></i> </span>
                                        </div>
                                        <select class="form-control" id="get_selected_date" wire:model="get_selected_date">
                                            <option value="2023">2023</option>
                                        </select>
                                        <div class="input-group-append pointer">
                                            <span style="border-radius: 0px; cursor: pointer;" class="input-group-text" wire:click.prevent="addedPlus"><i class="mdi mdi-chevron-right align-middle font-size-14"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('livewire.reports._default_filter')
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-xl-12 mt-1">
            <div class="card">
                <div class="row mt-0">
                    <div class="table-responsive last-row-bold">
                        <table class="table table-hover table-striped mb-0 ">
                            <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>COGS Price</th>
                                <th>Selling Price</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($orders as $item)
                                <tr>
                                    <td>{{ $item->sku_id }}</td>
                                    <td>{{ $item->variation_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->cogs_price }}</td>
                                    <td>{{ $item->selling_price }}</td>
                                    <td>{{ $item->total_sales_price }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">{{ __('No Record Found!') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <x-notify/>
    </div>
@push('footer')

@endpush

