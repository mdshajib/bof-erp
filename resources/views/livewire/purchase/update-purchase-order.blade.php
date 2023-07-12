<div>
    @section('page-title')
        Edit Purchase Order
    @endsection

    @section('header')
        <x-common.header title="Edit Purchase Order">
            <li class="breadcrumb-item">
                <a href="javascript: void(0);">Purchase Order Management</a>
            </li>
            <li class="breadcrumb-item active">Edit Purchase Order</li>
        </x-common.header>
    @endsection
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body p-3 order-create">
                    <div class="row">
                        <div class="col-md-4 col-lg-4">
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
                        <div class="col-md-4 col-lg-4">
                            <div class="mb-2">
                                <label for="internal_comments" class="form-label">Internal Comment</label>
                                <div class="form-group ">
                                    <input type="text" class="form-control" id="internal_comments" placeholder="internal comments" wire:model.defer="internal_comments" autocomplete="off" />
                                    @error('internal_comments') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-lg-4">
                            <div class="mb-2">
                                <label for="internal_comments" class="form-label">Amount Edit</label>
                                <div class="form-group ">
                                    <label class="form-check-label" for="amount_check">
                                        <input class="form-check-input channel" type="checkbox" id="amount_check" value='1' wire:model='confirmed'>
                                        <span> Amount Confirmed</span>
                                    </label>
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
                                        <th width="27%">Product Name</th>
                                        <th width="25%">Supplier</th>
                                        <th width="10%">Quantity</th>
                                        <th width="10%">COGS Price</th>
                                        <th width="11%">Selling Price</th>
                                        <th width="10%">Total</th>
                                        <th width="6%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @include('livewire.purchase._add_row')
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="col-md-4 mt-4 order-summary_table">
                                <table class="table invoice-table table-borderless mb-0 ">
                                    <tbody>
                                    <tr>
                                        <td>Sub Total</td>
                                        <td><strong>{{ $purchase_order_summary['sub_total'] }} Tk</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="col-md-4 mt-2">
                                <button type="button" wire:click="saveOrder"  class="btn btn-primary btn-light btn-label w-50 me-2" wire:loading.attr="disabled">
                                    <i class="fas fa-shopping-basket label-icon"></i>
                                    Confirm Order
                                    <div wire:loading>
                                        <i class="fas fa-spin fa-spinner mr-2"></i>
                                    </div>
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
