<x-modal :has-button="false" modal-id="orderViewModal" on="openOrderViewModal" title="{{ $order_number }}" size="xl">
@if($order_id)
<div class="row">
        <div class="col-sm-6">
            <div>
                <h5 class="font-size-15 mb-3">Billed For:</h5>
                <p class="mb-1"> Name: {{ $order_info['customer_name'] }} </p>
                <p class="mb-1"> Phone: {{ $order_info['customer_phone'] }} </p>
            </div>
{{--            @if ($internal_comments)--}}
                <div class="mt-4">
                    <h5 class="font-size-15">Internal Comments:</h5>
                    <p class="mb-1"> {{ $order_info['internal_comments'] }} </p>
                </div>
{{--            @endif--}}
        </div>
        <div class="col-sm-6">
            <div class="flex-shrink-0">
                <div class="mb-4">
                    <h4 class="float-end font-size-16">{{ $order_number }}</h4>
                </div>
            </div>
            <div>
                <div>
                    <h5 class="font-size-15">Order Date:</h5>
                    <p> {{ $order_info['order_date'] }} </p>
                </div>

                <div class="mt-4">
                    <h5 class="font-size-15">Order Notes:</h5>
                    <p class="mb-1"> {{ $order_info['order_notes'] }} </p>
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
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>COGS Price</th>
                            <th>Unit Price</th>
                            <th>Discount</th>
                            <th>Total Discount</th>
                            <th class="text-end" style="width: 120px;">Price</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($view_row_section as $product)
                        <tr>
                            <td> {{ $product['id'] }} </td>
                            <td>
                                <h5 class="font-size-15 mb-1"> {{ $product['product'] }} </h5>
                            </td>
                            <td> {{ $product['quantity'] }} </td>
                            <td>  {{ $product['cogs_price'] }} Tk</td>
                            <td>  {{ $product['unit_price'] }} Tk</td>
                            <td>  {{ $product['discount'] }} Tk</td>
                            <td>  {{ $product['total_discount'] }} Tk</td>
                            <td class="text-end">  {{ $product['gross_amount'] }} Tk</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <table class="table table-nowrap align-middle mb-0">
                    <tbody>
                        <tr>
                            <th scope="row" colspan="6" class="border-0 text-end">Sub Total (Without Discount)</th>
                            <td class="border-0 text-end">
                                {{ $order_summary['sub_total'] }} Tk
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="6" class="border-0 text-end"> Total Discount </th>
                            <td class="border-0 text-end"> {{ $order_summary['total_discount'] }} Tk</td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="6" class="border-0 text-end">Net Amount </th>
                            <td class="border-0 text-end"> {{ $order_summary['net_amount'] }} Tk</td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="6" class="border-0 text-end">Due</th>
                            <td class="border-0 text-end"><h4 class="m-0"> {{ $order_summary['due'] }} Tk</h4></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endif
</x-modal>

