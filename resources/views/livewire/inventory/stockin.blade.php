@section('page-title')
    Stock In
@endsection

@section('header')
    <x-common.header title="Stock In">
        <li class="breadcrumb-item">
            <a href="javascript: void(0);">Inventory Management</a>
        </li>
        <li class="breadcrumb-item active">Stock in</li>
    </x-common.header>
@endsection
<div class="row mt-4"  OnLoad="document.stock_form.sku.focus();">
    <div class="col-lg-5 col-md-5">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                    <form wire:submit.prevent="AddStock" name="stock_form">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <div>
                                        <h5 class="font-size-14 mb-3"><i class="mdi mdi-arrow-right text-primary me-1"></i>Stock Type</h5>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="stock_type" value="add" id="formRadios1" wire:model="stock_type" checked="">
                                            <label class="form-check-label" for="formRadios1">
                                                Add Stock
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <h5 class="font-size-14 mb-3">&nbsp;</h5>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="stock_type" value="adjust_plus" id="formRadios2" wire:model="stock_type">
                                            <label class="form-check-label" for="formRadios2">
                                                Adjust(+) Stock
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <h5 class="font-size-14 mb-3">&nbsp;</h5>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="stock_type" value="adjust_minus" id="formRadios3" wire:model="stock_type">
                                            <label class="form-check-label" for="formRadios3">
                                                Adjust(-) Stock
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- variant search box -->
                        <div class="mb-3">
                            <h5 for="searchVariant" class="form-label font-size-14">Enter Barcode</h5>
                            <div class="form-group has-search">
                                <span class="fa fa-search form-control-feedback"></span>
                                <input type="text" class="form-control" id="sku" name="sku" placeholder="Barcode" wire:model.defer="sku" autocomplete="off" autofocus onblur="focus();"/>
                                @error('variant_id') <span class="invalid-feedback d-block text-danger mb-3">{{ $message }}</span> @enderror
                            </div>
                            <!-- end variant search list -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7 col-md-7">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                    <x-table.table>
                        <x-slot name="head">
                            <tr>
                                <x-table.th>{{ __('Product') }}</x-table.th>
                                <x-table.th>{{ __('Stock Quantity') }}</x-table.th>
                                <x-table.th>{{ __('SKU') }}</x-table.th>
                                <x-table.th>{{ __('Type') }}</x-table.th>
                                <x-table.th>{{ __('Adjust') }}</x-table.th>
                            </tr>
                        </x-slot>
                        <x-slot name="body">
                            @php $i=0; @endphp
                            @forelse ($transactions as $transaction)
                                <tr>
                                    <td> {{ $transaction->variation?->variation_name }} </td>
                                    <td> {{ number_format($transaction->quantity , 2) }} </td>
                                    <td> {{ $transaction->sku_id }} </td>
                                    <td> {{ ucwords($transaction->type) }} </td>
                                    <td> {{ $transaction->is_adjust == 1 ? 'Yes' : 'No' }} </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">{{ __('No Record Found!') }}</td>
                                </tr>
                            @endforelse
                        </x-slot>
                    </x-table.table>
                </div>
            </div>
        </div>
    </div>
</div>
<x-notify/>

@push('footer')
    <script>
        function setupScanner() {
            alert('loaded..');
            let interval: any, barcode = '';
            document.onkeydown = (e) => {
                if(interval) {
                    clearInterval(interval)
                }
                if(e.code === 'Enter') {
                    if(barcode) {
                    }
                    barcode = '';
                    return;
                }
                if(e.key !== 'Shift') {
                    barcode += e.key;
                }
                interval = setInterval(() => barcode = '', 20);
            };
        }

        function focus(){
            document.stock_form.sku.focus();
        }
    </script>
@endpush

