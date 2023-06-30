<div>
    @section('page-title')
        Manage Products
    @endsection

    @section('header')
        <x-common.header title="Manage Products">
            <li class="breadcrumb-item">
                <a href="javascript: void(0);">Products Management</a>
            </li>
            <li class="breadcrumb-item active">Manage Products</li>
        </x-common.header>
    @endsection

    <x-action-box>
        <x-slot name="left">
            <div class="row">
                <div class="col-auto">
                    <a target="_blank" href="{{route('product.create')}}" class="btn waves-effect btn-primary">
                        <i class="fa fa-plus me-2"></i> Add New Product
                    </a>
                </div>
            </div>
        </x-slot>
        <x-slot name="right">
            <div class="d-flex justify-content-between">
                <x-form.select id="perPage" wire:model="perPage">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
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

                        <x-form.input id="txt_title_filter" wire:model.defer="filter.product" placeholder="{{ __('Product') }}" />
                        <x-form.select id="txt_category_filter" wire:model.defer="filter.category" placeholder="{{ __('Product Category') }}">
                            <option value="">-All Category-</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </x-form.select>

                        <button type="button" wire:click.prevent="search" class="btn btn-primary">Search</button>
                        <button type="button" wire:click.prevent="resetSearch" class="btn btn-link">Reset</button>

                    </x-offcanvas>
                </div>
            </div>

        </x-slot>
    </x-action-box>

    <x-table.table>
        <x-slot name="head">
            <tr>
                <x-table.th sortable :direction="$sorts['title'] ?? null" wire:click="sortBy('title')">{{ __('Product Title') }}</x-table.th>
                <x-table.th>{{ __('Category') }}</x-table.th>
                <x-table.th>{{ __('Variants') }}</x-table.th>
                <x-table.th>{{ __('Prices') }}</x-table.th>
                <x-table.th>{{ __('Supplier') }}</x-table.th>
                <x-table.th>{{ __('Featured Image') }}</x-table.th>
                <x-table.th style="width: 98px">{{ __('Status') }}</x-table.th>
                <x-table.th style="width: 90px">{{ __('Action') }}</x-table.th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @php $i=0; @endphp
            @forelse ($products as $product)
                <tr wire:key='{{ $product->id }}'>
                    <td width="18%">
                        {{ $product->title }}
                    </td>
                    <td>
                        <span class="badge badge-soft-primary"> {{ $product->category->name }} </span>
                    </td>
                    <td>
                        @if($product->variation)
                            @foreach($product->variation as $variation)
                                <span class="badge badge-soft-primary">{{$variation->variation_name}}</span>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if($product->variation)
                            @foreach($product->variation as $variation)
                                <span class="badge badge-soft-primary">{{$variation->selling_price}}</span>
                            @endforeach
                        @endif
                    </td>
                    <td> {{ $product->supplier->name }}, {{ $product->supplier->address }}</td>
                    <td>
                        @if($product->image_path)
                            <img src="{{ $product->image_path }}" alt="product-image" class="me-1" height="55">
                        @endif
                    </td>
                    <td>
                        @livewire('toggle-switch', ['model'=>$product, 'field'=>'is_active','name'=>$product->title], key($product->id))
                    </td>
                    <td></td>

                </tr>

            @empty
                <tr>
                    <td colspan="9" class="text-center">{{ __('No Record Found!') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table.table>
    <div class="row">
        <div class="col-sm-12 col-md-5"><?php echo pagination_stats_text($products); ?></div>
        <div class="col-sm-12 col-md-7">{{ $products->links() }}</div>
    </div>
    <x-notify/>
</div>
