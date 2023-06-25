<x-modal :has-button="false" modal-id="orderViewModal" on="openOrderViewModal" title="{{ $order_number }}" size="xl">
@if($order_id)
<div class="row">
        <div class="col-sm-6">
            <div>
                <h5 class="font-size-15 mb-3">Billed For:</h5>
                <p class="mb-1">Customer Name:</p>
                <p class="mb-1">Customer Phone:</p>
            </div>
{{--            @if ($internal_comments)--}}
                <div class="mt-4">
                    <h5 class="font-size-15">Internal Comments:</h5>
                    <p class="mb-1"></p>
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
                    <p></p>
                </div>

                <div class="mt-4">
                    <h5 class="font-size-15">Delivery Notes:</h5>
                    <p class="mb-1">Note</p>
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
                            <th>Unit Price</th>
                            <th>Discounted</th>
                            <th>Discounted Price</th>
                            <th class="text-end" style="width: 120px;">Price</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php $i=0; $two = 0; $seven = 0; @endphp
                        @foreach($view_row_section as $product)
                        <tr>
                            <th scope="row"></th>
                            <td>
                                <h5 class="font-size-15 mb-1"></h5>
                                <p class="font-size-13 text-muted mb-0"></p>
                            </td>
                            <td></td>
                            <td> CHF</td>
                            <td> CHF</td>
                            <td> CHF</td>
                            <td class="text-end"> CHF</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th scope="row" colspan="6" class="text-end">Sub Total(Without Discount & Vat)</th>
                            <td class="text-end"> CHF</td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="6" class="border-0 text-end">
                                Discount</th>
                            <td class="border-0 text-end"> CHF</td>
                        </tr>
                        @if( $two > 0)
                        <tr>
                            <th scope="row" colspan="6" class="border-0 text-end">
                                Vat(2.5%)</th>
                            <td class="border-0 text-end"> CHF
                            </td>
                        </tr>
                        @endif
                        @if( $seven > 0)
                        <tr>
                            <th scope="row" colspan="6" class="border-0 text-end">
                                Vat(7.7%)</th>
                            <td class="border-0 text-end">CHF
                            </td>
                        </tr>
                        @endif
                        @if(!$depot_total)
                        <tr>
                            <th scope="row" colspan="6" class="border-0 text-end">Delivery Charge</th>
                            <td class="border-0 text-end">
                            CHF
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="6" class="border-0 text-end">
                                Delivery Vat(7.7%)</th>
                            <td class="border-0 text-end"> CHF</td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="6" class="border-0 text-end">
                                Delivery Charge (With Vat)</th>
                            <td class="border-0 text-end"> CHF</td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="6" class="border-0 text-end">Total</th>
                            <td class="border-0 text-end"><h4 class="m-0"> CHF</h4></td>
                        </tr>
                        @endif
                    </tbody>
                </table>

                <div class="pb-3"><strong>Return Products</strong></div>
                <table class="table table-nowrap align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Item</th>
                            <th></th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th class="text-end" colspan="2">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <th scope="row" colspan="6" class="border-0 text-end">
                                Depot Return Amount</th>
                            <td class="border-0 text-end">CHF</td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="6" class="border-0 text-end">Delivery Charge</th>
                            <td class="border-0 text-end">
                            	CHF
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="6" class="border-0 text-end">
                                Delivery Vat(7.7%)</th>
                            <td class="border-0 text-end"> CHF</td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="6" class="border-0 text-end">
                                Delivery Charge (With Vat)</th>
                            <td class="border-0 text-end"> CHF</td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="6" class="border-0 text-end">Total</th>
                            <td class="border-0 text-end"><h4 class="m-0"> CHF</h4></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endif
</x-modal>

