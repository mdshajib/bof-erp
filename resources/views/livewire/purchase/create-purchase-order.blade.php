<div>
    @section('page-title')
        Create Purchase Order
    @endsection

    @section('header')
        <x-common.header title="Create Purchase Order">
            <li class="breadcrumb-item">
                <a href="javascript: void(0);">Purchase Order Management</a>
            </li>
            <li class="breadcrumb-item active">Create Purchase Order</li>
        </x-common.header>
    @endsection
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3 order-create">
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="mb-2">
                                        <label for="product_name" class="form-label">Product Name</label>
                                        <div class="form-group has-search">
                                            <span class="fa fa-search form-control-feedback"></span>
                                            <input type="text" class="form-control" id="product_name" placeholder="Product Name" wire:model="product_name" autocomplete="off" />
                                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        @if(count($product_list) > 0)
                                            <div class="dialog">
                                                @foreach($product_list as $product_variation)
                                                    <a wire:click.prevent="getProductInfo({{$product_variation->id}})">
                                                        <div> {{$product_variation->variation_name}} </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-1">
                            <div class="table-responsive mt-1 order">
                                <table class="table invoice-table-light mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th width="30%">Product Name</th>
                                        <th width="15%">Quantity</th>
                                        <th width="15%">Unit Price</th>
                                        <th width="8%">Discount</th>
                                        <th width="10%">Total Discount</th>
                                        <th width="8%">Total</th>
                                        <th width="6%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
{{--                                    @include('livewire.order._add_row')--}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="col-md-4 mt-4 order-summary_table">
                                <table class="table invoice-table table-borderless mb-0 ">
                                    <tbody>
                                    <tr>
                                        <td>Sub Total (Without Discount)</td>
                                        <td><strong>{{ $purchase_order_summary['sub_total'] }} Tk</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Total Discount</td>
                                        <td><strong> {{ $purchase_order_summary['total_discount'] }} Tk</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Net Amount</td>
                                        <td><strong> {{ $purchase_order_summary['net_amount'] }} Tk</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="col-md-4 mt-2">
                                <button type="button" wire:click="saveOrder"  class="btn btn-primary btn-light btn-label w-50 me-2">
                                    <i class="fas fa-shopping-basket label-icon"></i>
                                    Confirm Order
                                </button>
                                <button type="button" wire:click="orderCancel"  class="btn btn-danger btn-label w-46">
                                    <i class="bx bx-block label-icon"></i>
                                    Cancel Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <x-notify/>
</div>

@push('footer')

@endpush
