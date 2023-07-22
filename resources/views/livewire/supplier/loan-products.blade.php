<div>
    @section('page-title')
        Loan Products
    @endsection


    @section('header')
        <x-common.header title="Loan Products">
            <li class="breadcrumb-item">
                <a href="javascript: void(0);">Supplier Management</a>
            </li>
            <li class="breadcrumb-item active">Loan Products</li>
        </x-common.header>
    @endsection

    <x-action-box>
        <x-slot name="right">
            <div class="d-flex justify-content-between">
                <x-form.select id="perPage" wire:model="perPage">
                    <option value="5"> 5 </option>
                    <option value="10"> 10 </option>
                    <option value="50"> 50 </option>
                    <option value="100"> 100 </option>
                </x-form.select>

                <div class="ms-2">
                    <button
                        class="btn btn-primary"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasFilter"
                        aria-controls="offcanvasFilter">
                        <i class="fa fa-filter pe-2"></i> Search
                    </button>
                    <x-offcanvas id="offcanvasFilter" size="sm" title="Search">
                        <form>
                            <x-form.input id="txt_name_filter" wire:model.defer="filter.purchase_id" placeholder="{{ __('Purchase No') }}" />
                            <button type="submit" wire:click.prevent="search" class="btn btn-primary">Search</button>
                            <button type="button" wire:click.prevent="resetSearch" class="btn btn-link">Reset</button>
                        </form>
                    </x-offcanvas>
                </div>
            </div>

        </x-slot>

    </x-action-box>

    <x-table.table>
        <x-slot name="head">
            <tr>
                <x-table.th>Product</x-table.th>
                <x-table.th>SKU</x-table.th>
                <x-table.th>Supplier</x-table.th>
                <x-table.th>Quantity</x-table.th>
                <x-table.th>COGS Price</x-table.th>
                <x-table.th>Selling Price</x-table.th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @forelse($products as $product)
                <tr>
                    <td>{{ $product?->variation->variation_name }}</td>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product?->supplier?->name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->quantity * $product->cogs_price }}</td>
                    <td>{{ $product->quantity * $product->selling_price }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No Records Found!</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table.table>
    <div class="row">
        <div class="col-sm-12 col-md-5">{{ pagination_stats_text($products) }} </div>
        <div class="col-sm-12 col-md-7">{{ $products->links() }}</div>
    </div>
    <x-notify/>
</div>
