<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="row">
            Top Menu
        </div>
        <div class="row">
            <div class="col-lg-7 col-md-7">
                <div class="card">
                    <div class="card-body">
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
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-1">
                                <div class="table-responsive mt-1 order sale-box">
                                    <table class="table invoice-table-light mb-0">
                                        <thead class="table-light">
                                        <tr>
                                            <th width="30%">Product Name</th>
                                            <th width="15%">Quantity</th>
                                            <th width="15%">Price</th>
                                            <th width="6%">Stock</th>
                                            <th width="6%" style="text-align: center"> <i class="fas fa-times" aria-hidden="true"></i> </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @include('livewire.new-pos._add_row')
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6 pt-2 pb-2">
                                <div class="product-image">
                                    <img style="width: 70px;" src="https://bof-erp.test/storage/products/168917574501_6131d39914cf8.jpeg">
                                </div>
                                <div class="product-name">
                                    <p class="pt-2">Black Coffee</p>
                                    <p class="pt-2">Small</p>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6 pt-2 pb-2">
                                <div class="product-image">
                                    <img style="width: 70px;" src="https://bof-erp.test/storage/products/168917574501_6131d39914cf8.jpeg">
                                </div>
                                <div class="product-name">
                                    <p class="pt-2">Black Coffee</p>
                                    <p class="pt-2">Small</p>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6 pt-2 pb-2">
                                <div class="product-image">
                                    <img style="width: 70px;" src="https://bof-erp.test/storage/products/168917574501_6131d39914cf8.jpeg">
                                </div>
                                <div class="product-name">
                                    <p class="pt-2">Black Coffee</p>
                                    <p class="pt-2">Small</p>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6 pt-2 pb-2">
                                <div class="product-image">
                                    <img style="width: 70px;" src="https://bof-erp.test/storage/products/168917574501_6131d39914cf8.jpeg">
                                </div>
                                <div class="product-name">
                                    <p class="pt-2">Black Coffee</p>
                                    <p class="pt-2">Small</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <button class="btn btn-primary">Submit Order</button>
                <button class="btn btn-primary">Cancel Order</button>
                <button class="btn btn-primary">Submit Order</button>
                <button class="btn btn-primary">Submit Order</button>
            </div>
        </div>
    </div>
</div>
