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

    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <div id="progrss-wizard" class="twitter-bs-wizard">
                        <ul class="twitter-bs-wizard-nav nav nav-pills nav-justified">
                            <li class="nav-item">
                                <a href="#progress-product-basic-information" wire:click="stepSet(1)" class="nav-link {{ $currentStep != 1 ? '' : 'active' }} @if($product_id) disabled @endif" data-toggle="tab">
                                    <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Basic Information">
                                        <i class="fas fa-cubes"></i>
                                    </div>
                                </a>
                                <span class="badge bg-none text-black {{ $currentStep != 1 ? '' : 'active' }}">Product Basic Information</span>
                            </li>
                            <li class="nav-item">
                                <a href="#progress-product-varient" wire:click="stepSet(2)" class="nav-link {{ $currentStep != 2 ? '' : 'active' }} @if(!$product_id) disabled @endif" data-toggle="tab">
                                    <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Variation">
                                        <i class="bx bx-palette"></i>
                                    </div>
                                </a>
                                <span class="badge bg-none text-black {{ $currentStep != 2 ? '' : 'active' }}">Product Variation</span>
                            </li>

                            <li class="nav-item">
                                <a href="#progress-product-price" wire:click="stepSet(3)" class="nav-link {{ $currentStep != 3 ? '' : 'active' }} @if(!$product_id) disabled @endif" data-toggle="tab">
                                    <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Price">
                                        <i class="bx bx-dollar"></i>
                                    </div>
                                </a>
                                <span class="badge bg-none text-black {{ $currentStep != 3 ? '' : 'active' }}">Product Price</span>
                            </li>

                            <li class="nav-item">
                                <a href="#progress-product-media" wire:click="stepSet(4)" class="nav-link {{ $currentStep != 4 ? '' : 'active' }} @if(!$product_id) disabled @endif" data-toggle="tab">
                                    <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Image">
                                        <i class=" bx bxs-image-add"></i>
                                    </div>
                                </a>
                                <span class="badge bg-none text-black {{ $currentStep != 4 ? '' : 'active' }}">Product Image</span>
                            </li>
                        </ul>
                        <!-- wizard-nav -->

                        <div id="bar" class="progress mt-4">
                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width:{{$progress}};"></div>
                        </div>
                        <div class="tab-content twitter-bs-wizard-tab-content">
                            <div class="tab-pane {{ $currentStep == 1 ? 'active' : '' }}" id="progress-product-basic-information">
                                <div class="text-left mb-4">
                                    <h5>Product Basic Information</h5>
                                    <p class="card-title-desc">Fill all information below</p>
                                </div>
                                <form>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="row mt-1">
                                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                                        <div class="mb-3">
                                                            <label class="required" for="category">Product Category</label>
                                                            <x-form.select id="category" wire:model.defer="product_info.category" placeholder="{{ __('Category') }}">
                                                                <option value="">Select Category</option>
                                                                @foreach($categories as $category)
                                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                @endforeach
                                                            </x-form.select>
                                                            @error('product_info.category') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                                        <div class="mb-3">
                                                            <label class="required" for="supplier">Supplier</label>
                                                            <x-form.select id="supplier" wire:model.defer="product_info.supplier" placeholder="{{ __('Supplier') }}">
                                                                <option value="">Select Supplier</option>
                                                                @foreach($suppliers as $supplier)
                                                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}, {{ $supplier->address }}</option>
                                                                @endforeach
                                                            </x-form.select>
                                                            @error('product_info.supplier') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                                        <div class="mb-3">
                                                            <label class="required" for="Title">Title</label>
                                                            <x-form.input  type="text" wire:model.defer="product_info.title" placeholder="{{ __('Title') }}" id="Title"></x-form.input>
                                                            @error('product_info.title') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                                        <div class="mb-3">
                                                            <label class="" for="type">Product Type</label>
                                                            <x-form.select id="type" wire:model.defer="product_info.type" placeholder="{{ __('Product Type') }}">
                                                                <option value="finished-product">Finished Product</option>
                                                                <option value="raw-material">Raw Material</option>
                                                            </x-form.select>
                                                            @error('product_info.type') <span class="text-danger">{{ $message }}</span> @enderror

                                                        </div>
                                                    </div>
                                                </div>

                                        </div>
                                    </div>
                                </form>
                                <ul class="pager wizard twitter-bs-wizard-pager-link">
                                    <li class="next">
                                        <a href="javascript: void(0);" class="btn btn-primary" wire:click="productInfoSubmit">Next <i class="bx bx-chevron-right ms-1"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane {{ $currentStep == 2 ? 'active' : '' }}" id="progress-product-varient">
                                <div>
                                    <div class="text-left mb-4">
                                        <h5>Product Variant</h5>
                                        <p class="card-title-desc">Fill in all information below</p>
                                    </div>
                                    <form>
                                        <div class="row">
                                            @if($product_id)
                                                <div class="col-lg-12 d-none">
                                                    <div class="mb-3">
                                                        <label for="product_id" class="form-label">Product ID</label>
                                                        <input type="text" class="form-control" id="product_id" name="product_id" value="{{$product_id}}" wire:model="product_id" placeholder="Enter your product product_id here" readonly>
                                                        @error('product_id') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        @include('livewire.product._add_variation')
                                    </form>
                                    <ul class="pager wizard twitter-bs-wizard-pager-link">
                                        <li class="previous"><a href="javascript: void(0);" class="btn btn-secondary" wire:click="previous(1)"><i
                                                    class="bx bx-chevron-left me-1 fa-color-primary"></i> Previous</a></li>
                                        <li class="next"><a href="javascript: void(0);" class="btn btn-primary" wire:click.prevent="productVariationSubmit">Next <i class="bx bx-chevron-right ms-1"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-pane {{ $currentStep == 3 ? 'active' : '' }}" id="progress-product-price">
                                <div>
                                    <div class="text-left mb-4">
                                        <h5>Product Price</h5>
                                        <p class="card-title-desc">Fill in all information below</p>
                                    </div>
                                    <form>
                                        <div class="row">
                                            @include('livewire.product._add_price')
                                        </div>

                                    </form>
                                    <ul class="pager wizard twitter-bs-wizard-pager-link">
                                        <li class="previous"><a href="javascript: void(0);" class="btn btn-secondary" wire:click.prevent = "previous(2)"><i
                                                    class="bx bx-chevron-left me-1 fa-color-primary"></i> Previous</a></li>
                                        <li class="float-end"><a href="javascript: void(0);" class="btn btn-primary" wire:click.prevent = "productPriceSubmit">Next <i class="bx bx-chevron-right ms-1"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="tab-pane {{ $currentStep == 4 ? 'active' : '' }}" id="progress-product-media">
                                <div>
                                    <div class="text-left mb-4">
                                        <h5>Product Image/Video</h5>
                                        <p class="card-title-desc">Fill in all information below</p>
                                    </div>
                                    @include('livewire.product._add_image')
                                    <ul class="pager wizard twitter-bs-wizard-pager-link">
                                        <li class="previous"><a href="javascript: void(0);" class="btn btn-secondary" wire:click="previous(3)"><i
                                                    class="bx bx-chevron-left me-1 fa-color-primary"></i> Previous</a></li>
                                        <li class="float-end">
                                            <button href="javascript: void(0);" class="btn btn-primary"  wire:click="productMediaSubmit" wire:loading.attr="disabled">
                                                <div wire:loading>
                                                    <i class="fas fa-spin fa-spinner mr-2"></i>
                                                </div>
                                                Save
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--        @include('livewire.x-loading')--}}
    <x-notify/>
</div>

@push('footer')

@endpush
