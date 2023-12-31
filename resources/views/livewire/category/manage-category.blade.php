<div>
    @section('page-title')
        Manage Category
    @endsection

    @section('header')
        <x-common.header title="Manage Category">
            <li class="breadcrumb-item">
                <a href="javascript: void(0);">Category Management</a>
            </li>
            <li class="breadcrumb-item active">Manage Category</li>
        </x-common.header>
    @endsection
    <x-action-box>
        <x-slot name="left">
            <div class="row">
                <div class="col-auto">
                    <button type="button" wire:click.prevent="openNewCategoryModal()" class="btn waves-effect btn-primary">
                        <i class="fa fa-plus me-2"></i> New Category
                    </button>
                    @include('livewire.category._add_category')
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
                        <form>
                            <x-form.input id="txt_name_filter" wire:model.defer="filter.name" placeholder="{{ __('Category Name') }}" />
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
                <x-table.th sortable :direction="$sorts['name'] ?? null" wire:click="sortBy('name')">{{ __('Category Name') }}</x-table.th>
                <x-table.th>{{ __('Slug') }}</x-table.th>
                <x-table.th>{{ __('Type') }}</x-table.th>
                <x-table.th>{{ __('Status') }}</x-table.th>
                <x-table.th style="width: 62px">{{ __('Action') }}</x-table.th>
            </tr>
            @if ( count($selected) > 0 )
                <tr>
                    <th colspan="6" class="text-center font-weight-normal text-muted">
                        @unless ($selectAll)
                            <div>
                        <span>
                            You have selected <strong>{{ count($selected) }}</strong> category,</span>
                                <span> do you want to select all <strong>{{ $category_list->total() }}</strong>?
                        </span>
                                <button wire:click="selectAll" class="ml-1 btn btn-link">Select All</button>
                            </div>
                        @else
                            <span>You are currently selecting all <strong>{{ $category_list->total() }}</strong> category.</span>
                        @endif
                    </th>
                </tr>
            @endif
        </x-slot>
        <x-slot name="body">
            @forelse($category_list as $category)
                <tr wire:key='{{ $category->id }}'>

                    <td>
                        {{$category->name}}
                    </td>
                    <td>{{$category->slug}}</td>
                    <td>
                        {{ucwords($category->type) }}
                    </td>
                    <td>
                        @livewire('toggle-switch', ['model'=>$category, 'field'=>'is_active'], key($category->id))
                    </td>
                    <td>
                        <button type="button" wire:click="openCategoryEditModal({{$category->id}})" wire:loading.class="bg-gray" class="btn btn-secondary btn-sm"><i class="fa fa-edit"></i></button>
{{--                        <button wire:click="CategoryconfirmDelete({{ $category->id }})" class="btn btn-primary btn-sm"><i class="fas fa-trash"></i></button>--}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">{{ __('No Record Found!') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table.table>
    <div class="row">
{{--        <div class="col-sm-12 col-md-5">{{ pagination_stats_text($category_list) }}</div>--}}
        <div class="col-sm-12 col-md-7">{{ $category_list->links() }}</div>
    </div>
    @include('livewire.category._edit_category')
    @include('livewire.x-loading')
    <x-notify/>
</div>
