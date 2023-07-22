<x-modal :has-button="false" modal-id="orderViewModal" on="openOrderViewModal" title="{{ $purchase_number }}" size="xl">
@if($purchase_id)
<div class="row">
        <div class="col-sm-6">
                <div class="mt-4">
                    <h5 class="font-size-15">Internal Comments:</h5>
                    <p class="mb-1"> {{ $order_info['internal_comments'] }} </p>
                </div>
        </div>
        <div class="col-sm-6">
            <div class="flex-shrink-0">
                <div class="mb-4">
                    <h4 class="float-end font-size-16">{{ $purchase_number }}</h4>
                </div>
            </div>
            <div>
                <div>
                    <h5 class="font-size-15">Order Date:</h5>
                    <p> {{ $order_info['order_date'] }} </p>
                </div>
            </div>
        </div>
        <div class="py-2 mt-3">
            <h5 class="font-size-15">Order summary</h5>
        </div>
        <div class="p-4 border rounded">
            <div class="table-responsive">
                <table class="table table-nowrap align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 70px;">No.</th>
                            <th width="27%">Product Name</th>
                            <th width="25%">Supplier</th>
                            <th width="8%">Loan</th>
                            <th width="10%">Quantity</th>
                            <th width="10%">COGS Price</th>
                            <th width="11%">Selling Price</th>
                            <th width="10%" class="text-end" style="width: 120px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($view_row_section as $product)
                        <tr>
                            <td> {{ $product['id'] }} </td>
                            <td>
                                <h5 class="font-size-15 mb-1"> {{ $product['product'] }} </h5>
                            </td>
                            <td> {{ $product['supplier'] }} </td>
                            <td>
                                @if($product['loan'])
                                    Yes
                                @else
                                    -
                                @endif
                            </td>
                            <td> {{ $product['quantity'] }} </td>
                            <td>  {{ $product['cogs_price'] }} Tk</td>
                            <td>  {{ $product['selling_price'] }} Tk</td>
                            <td class="text-end">  {{ $product['gross_amount'] }} Tk</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <table class="table table-nowrap align-middle mb-0">
                    <tbody>
                        <tr>
                            <th scope="row" colspan="6" class="border-0 text-end">Sub Total</th>
                            <td class="border-0 text-end">
                                {{ $order_summary['sub_total'] }} Tk
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endif
</x-modal>

