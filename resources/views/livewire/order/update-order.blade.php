<div>
    @section('page-title')
        Edit Order
    @endsection

    @section('header')
        <x-common.header title="Edit Order ">
            <li class="breadcrumb-item">
                <a href="javascript: void(0);">Order Management</a>
            </li>
            <li class="breadcrumb-item active">Edit Order</li>
        </x-common.header>
    @endsection
    <div class="row" OnLoad="document.product_find.barcode.focus();">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3 order-create">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label for="phone" class="form-label">Customer Phone</label><br/>
                                <label for="phone" class="form-label">{{ $phone }}</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label for="customer_name" class="form-label">Customer Name</label> <br/>
                                <label for="customer_name" class="form-label">{{ $name }}</label>
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
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @include('livewire.order._show_row')
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
                                <button type="button" wire:click="saveOrder"  class="btn btn-primary btn-light btn-label w-50 me-2" wire:loading.attr="disabled">
                                    <i class="fas fa-shopping-basket label-icon"></i>
                                    Confirm Order
                                    <div wire:loading>
                                        <i class="fas fa-spin fa-spinner mr-2"></i>
                                    </div>
                                </button>
                                <a href="{{ route('order.manage') }}"  class="btn btn-danger btn-label w-46" >
                                    <i class="bx bx-block label-icon"></i>
                                    Cancel Order
                                </a>
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
