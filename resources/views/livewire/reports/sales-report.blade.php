<div>
    @section('page-title')
        Sales Report
    @endsection

    @section('header')
        <x-common.header title="Sales Report">
            <li class="breadcrumb-item">
                <a href="javascript: void(0);">Reports</a>
            </li>
            <li class="breadcrumb-item active">Sales</li>
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
                                    <x-form.input required="required" id="datepicker-range" wire:model.defer="dates" class="form-control flatpickr-input active" label="{{ __('Dates') }}" :error="$errors->first('dates')" placeholder="Date" autocomplete="off"/>
                                </div>
                            </div>
                            @include('livewire.reports._default_filter')
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-xl-12 mt-1" >
            <div class="card">
                <div class="row mt-0">
                    <div class="table-responsive last-row-bold">
                        <table class="table table-hover table-striped mb-0 ">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Purchase Order</th>
                                <th>Quantity</th>
                                <th>Total COGS Price | COGS Price</th>
                                <th>Total Selling Price | Selling Price</th>
                                <th>Profit</th>
                                <th>Loss</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($orders as $item)
                                <tr>
                                    @php
                                        $profit = 0; $loss  = 0;
                                        $total_cogs        = $item['cogs_price'] * $item['quantity'];
                                        $total_sales_price = $item['total_sales_price'];
                                        if($total_cogs > $total_sales_price){
                                            $loss = $total_cogs - $total_sales_price;
                                        }else{
                                            $profit = $total_sales_price - $total_cogs;
                                        }

                                    @endphp
                                    <td>{{ $item['variation_name'] }}</td>
                                    <td>{{ $item['sku_id'] }}</td>
                                    <td>
                                        <a href="{{ route('purchase.view', ['purchase_id' => $item['purchase_order_id']]) }}">
                                            PR#{{ str_pad($item['purchase_order_id'], 6, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>{{ $item['cogs_price'] * $item['quantity'] }} | {{ $item['cogs_price'] }}</td>
                                    <td>{{ $item['total_sales_price'] }} | {{ $item['unit_sales_price'] }}</td>
                                    <td>{{ $profit }}</td>
                                    <td>{{ $loss }}</td>
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
     <script>
         $("#datepicker-range").flatpickr({
            mode: "range",
            maxDate: "today",
            dateFormat: "Y-m-d"
         });
     </script>
@endpush

