<div>
    @section('page-title')
        Add Product
    @endsection
    @section('header')
        <x-common.header title="Add Product">
            <li class="breadcrumb-item">
                <a href="javascript: void(0);">Product Management</a>
            </li>
            <li class="breadcrumb-item active">Add Product</li>
        </x-common.header>
    @endsection
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <fieldset class="fieldset-border">
                <legend class="fieldset-border">Product Info</legend>
                <div class="row mt-2">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
                        <div class="mb-3">
                            <label class="required" for="category">Product Category</label>
                            <x-form.select id="category" wire:model.defer="product_info.category" placeholder="{{ __('Product Category') }}">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </x-form.select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <div class="mb-3">
                            <label class="required" for="txt_supplier">Supplier</label>
                            <x-form.select id="txt_supplier" wire:model.defer="product_info.supplier" placeholder="{{ __('Supplier') }}">
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}, {{ $supplier->address }}</option>
                                @endforeach
                            </x-form.select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <div class="mb-3">
                            <x-form.input
                                type="text" wire:model.defer='product_info.title' id="txt_title"
                                label="Title"  placeholder="Title" :error="$errors->first('product_info.title')"
                            />
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="mb-3">
                            <x-form.input
                                type="text" wire:model.defer='product_info.description' id="txt_description"
                                label="Description"  placeholder="Description" :error="$errors->first('product_info.description')"
                            />
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="fieldset-border">
                <legend class="fieldset-border">Product Info</legend>
                <div class="row mt-2">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
                        <div class="mb-3">
                            <label class="required" for="category">Product Category</label>
                            <x-form.select id="category" wire:model.defer="product_info.category" placeholder="{{ __('Product Category') }}">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </x-form.select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <div class="mb-3">
                            <label class="required" for="txt_supplier">Supplier</label>
                            <x-form.select id="txt_supplier" wire:model.defer="product_info.supplier" placeholder="{{ __('Supplier') }}">
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}, {{ $supplier->address }}</option>
                                @endforeach
                            </x-form.select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <div class="mb-3">
                            <x-form.input
                                type="text" wire:model.defer='product_info.title' id="txt_title"
                                label="Title"  placeholder="Title" :error="$errors->first('product_info.title')"
                            />
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="mb-3">
                            <x-form.input
                                type="text" wire:model.defer='product_info.description' id="txt_description"
                                label="Description"  placeholder="Description" :error="$errors->first('product_info.description')"
                            />
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

    @include('livewire.x-loading')
    <x-notify/>
</div>

@push('footer')

@endpush
