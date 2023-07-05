<div>
@section('page-title')
    Order Create
@endsection

@section('header')
    <x-common.header title="Order Create ">
        <li class="breadcrumb-item">
            <a href="javascript: void(0);">Order Management</a>
        </li>
        <li class="breadcrumb-item active">Order Create</li>
    </x-common.header>
@endsection
<div class="row" OnLoad="document.product_find.barcode.focus();">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-3 order-create">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="mb-2">
                                    <form wire:submit.prevent="readBarcode" name="product_find">
                                        <label for="barcode" class="form-label required">Barcode</label>
                                        <div class="form-group has-search">
                                            <span class="fa fa-search form-control-feedback"></span>
                                            <input type="text" class="form-control" id="barcode" placeholder="Barcode" wire:model.defer="barcode" autofocus autocomplete="off" />
                                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="mb-2">
                                    <label for="product_name" class="form-label">Or Product Name</label>
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
                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="phone" class="form-label">Customer Phone</label>
                            <div class="form-group has-search">
                                <span class="fa fa-search form-control-feedback"></span>
                                <input type="text" class="form-control" id="phone" placeholder="Customer Phone" wire:model.defer="phone" autocomplete="off" />
                                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="customer_name" placeholder="Customer Name" wire:model.defer="customer_name" autocomplete="off" />
                                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="order_note" class="form-label">Order Notes</label>
                            <input type="text" class="form-control" id="order_note" placeholder="Enter Order notes" wire:model.defer="order_note">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="internal_comments" class="form-label">Internal Comments</label>
                            <input type="text" class="form-control" id="internal_comments" placeholder="Internal comments here" wire:model.defer="internal_comments">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="paid_amount" class="form-label required">Paid Amount</label>
                            <input type="number" class="form-control" id="paid_amount" placeholder="Paid Amount" wire:model.lazy="paid_amount">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-2">
                            <label for="paid_amount" class="form-label required">Payment Method</label>
                            <select class="form-control" wire:model.defer="payment_method">
                                <option value="cash">Cash</option>
                                <option value="bkash">Bkash</option>
                                <option value="card">Card</option>
                            </select>
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
                                    <th width="6%">Stock</th>
                                    <th width="6%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @include('livewire.order._add_row')
                                </tbody>
                            </table>
                        </div>
                        {{--                            <div class="mt-4">--}}
                        {{--                                <button class="btn btn-primary" wire:click.prevent="addRow"><i class="fa fa-plus-square"></i> &nbsp;Add Item</button>--}}
                        {{--                            </div>--}}
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="col-md-4 mt-4 order-summary_table">
                            <table class="table invoice-table table-borderless mb-0 ">
                                <tbody>
                                <tr>
                                    <td>Sub Total (Without Discount)</td>
                                    <td><strong>{{ $order_summary['sub_total'] }} Tk</strong></td>
                                </tr>
                                <tr>
                                    <td>Total Discount</td>
                                    <td><strong> {{ $order_summary['total_discount'] }} Tk</strong></td>
                                </tr>
                                <tr>
                                    <td>Net Amount</td>
                                    <td><strong> {{ $order_summary['net_amount'] }} Tk</strong></td>
                                </tr>
                                <tr>
                                    <td>Due</td>
                                    <td><strong> {{ $order_summary['due'] }} Tk</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="col-md-4 mt-2">
{{--                            <div class="d-grid gap-2">--}}
{{--                                <button type="button" wire:click="saveOrder"  class="btn btn-primary btn-light">Confirm Order</button>--}}
{{--                            </div>--}}
                            <button type="button" wire:click="saveOrder"  class="btn btn-primary btn-light btn-label w-50 me-2" wire:loading.attr="disabled">
                                <i class="fas fa-shopping-basket label-icon"></i>
                                Confirm Order
                                <div wire:loading>
                                    <i class="fas fa-spin fa-spinner mr-2"></i>
                                </div>
                            </button>
                            <button type="button" wire:click="orderCancel"  class="btn btn-danger btn-label w-46" >
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
