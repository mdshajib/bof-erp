
<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
    <div class="mb-1">
        <label for="category_id">Category</label>
        <select class="form-control" name="category_id" id="category_id" wire:model="get_category_id">
            <option value="">Choose a category</option>
            @foreach($category_list as $category)
                <option value="{{$category['id']}}" >{{$category['name']}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="mb-1">
        <label for="product_id">Product</label>
        <select class="form-select" id="product_id" wire:model.defer="get_product_id">
            <option value="">Choose a product</option>
            @foreach ($product_list as $product)
                <option value="{{ $product['id'] }}">{{ $product['name'] }}</option>
            @endforeach
        </select>
        @error('product_id') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
</div>

<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 pt-4">
    <div class="float-start">
        <button class="btn waves-effect btn-primary my-2" style="margin-right: 2px;" wire:click.prevent="generatePosReport" wire:loading.attr="disabled">
            <i class="fa fa-filter"></i>
            <span wire:loading.remove>Apply</span>
            <span wire:loading>Wait...</span>
        </button>
        <button class="btn waves-effect btn-primary my-2" style="margin-right: 2px;" wire:click.prevent="resetFilter" style="min-width: 66px;"><i class="fa fa-eraser"></i> Reset</button>
        <button class="btn waves-effect btn-primary my-2" wire:loading.attr="disabled"
                wire:click.prevent="downloadExcel" style="min-width: 66px;" {{ $disabled ? 'disabled' : '' }}><i class="fa fa-download"></i>
            <span wire:loading.remove>Download</span>
            <span wire:loading>Wait...</span>
        </button>
    </div>
</div>
</div>
@push('footer')
    <script>
        $(document).ready(function(){

            $('#category_id').select2({
                placeholder: "Choose a category",
                theme: 'bootstrap-5',
            });
            $('#product_id').select2({
                placeholder: "Choose a product",
                theme: 'bootstrap-5',
            });

            $('#category_id').on("select2:select select2:unselect", function () {
                let dataContact = $(this).val();
            @this.set('get_category_id', dataContact);
            });

            $('#product_id').on("select2:select select2:unselect", function () {
                let dataContact = $(this).val();
            @this.set('get_product_id', dataContact);
            });

        });

    </script>
@endpush
