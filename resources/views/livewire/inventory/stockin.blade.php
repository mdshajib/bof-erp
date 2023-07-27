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
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified mb-2" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab == 'addStock' ? 'active' : ''}}" data-bs-toggle="tab" href="#addStock" role="tab" wire:click="stepActive(1)">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Add Stock</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab == 'adjustPlus' ? 'active' : ''}}" data-bs-toggle="tab" href="#adjustPlus" role="tab" wire:click="stepActive(2)">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Adjust Stock(+)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab == 'adjustMinus' ? 'active red-bg' : ''}}" data-bs-toggle="tab" href="#adjustMinus" role="tab" wire:click="stepActive(3)">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block {{ $activeTab == 'adjustMinus' ? 'text-white' : ''}}">Adjust Stock(-)</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content text-muted">
                        <div class="tab-pane {{ $activeTab == 'addStock' ? 'active' : ''}}" id="addStock" role="tabpanel">
                            <form wire:submit.prevent="AddStock" name="stock_form">
                                <div class="mb-3">
                                    <h5 for="sku" class="form-label font-size-14">Enter Barcode</h5>
                                    <div class="form-group has-search">
                                        <span class="fa fa-search form-control-feedback"></span>
                                        <input type="text" class="form-control" id="sku" name="sku" placeholder="Barcode" wire:model.lazy="sku" autocomplete="off" autofocus onblur="focus();"/>
                                        @error('variant_id') <span class="invalid-feedback d-block text-danger mb-3">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane {{ $activeTab == 'adjustPlus' ? 'active' : ''}}" id="adjustPlus" role="tabpanel">
                            <div class="mb-3">
                                <form class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <div class="form-group has-search">
                                                <span class="fa fa-search form-control-feedback"></span>
                                                <input type="text" class="form-control" id="sku" name="sku" placeholder="Barcode" wire:model.defer="sku" autocomplete="off" autofocus />
                                                @error('variant_id') <span class="invalid-feedback d-block text-danger mb-3">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="number" class="form-control" id="quantity" wire:model.defer="quantity" placeholder="Qt">
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="mb-3 ">
                                            <input type="text" class="form-control" id="note" name="note" placeholder="note *" wire:model.defer="note" />
                                            @error('note') <span class="invalid-feedback d-block text-danger mb-3">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <button class="btn form-control btn-primary" wire:click.prevent="adjustPlus"> Adjust <i class="fa fa-plus ms-2"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane {{ $activeTab == 'adjustMinus' ? 'active' : ''}}" id="adjustMinus" role="tabpanel">
                            <div class="mb-3">
                                <form class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <div class="form-group has-search">
                                                <span class="fa fa-search form-control-feedback"></span>
                                                <input type="text" class="form-control" id="sku" name="sku" placeholder="Barcode" wire:model.defer="sku" autocomplete="off" autofocus />
                                                @error('variant_id') <span class="invalid-feedback d-block text-danger mb-3">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="number" class="form-control" id="quantity" wire:model.defer="quantity" placeholder="Qt">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mb-3 ">
                                            <input type="text" class="form-control" id="note" name="note" placeholder="note *" wire:model.defer="note" />
                                            @error('note') <span class="invalid-feedback d-block text-danger mb-3">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <button class="btn form-control btn-danger" wire:click.prevent="adjustMinus"> Adjust <i class="fa fa-minus ms-2"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
        // function setupScanner() {
        //     alert('loaded..');
        //     let interval: any, barcode = '';
        //     document.onkeydown = (e) => {
        //         if(interval) {
        //             clearInterval(interval)
        //         }
        //         if(e.code === 'Enter') {
        //             if(barcode) {
        //             }
        //             barcode = '';
        //             return;
        //         }
        //         if(e.key !== 'Shift') {
        //             barcode += e.key;
        //         }
        //         interval = setInterval(() => barcode = '', 20);
        //     };
        // }

        function focus(){
            document.stock_form.sku.focus();
        }
    </script>
@endpush

