<?php

namespace App\Http\Livewire\Product;

use App\Http\Livewire\BaseComponent;
use App\Models\Category;
use App\Models\Product;
use App\Traits\WithBulkActions;
use App\Traits\WithCachedRows;
use App\Traits\WithPerPagePagination;
use App\Traits\WithSorting;

class ManageProduct extends BaseComponent
{
    use WithPerPagePagination;
    use WithCachedRows;
    use WithSorting;
    use WithBulkActions;

    public $categories = [];

    public $filter = [
        'product'    => null,
        'category'   => null
    ];

    public function mount()
    {
        $this->categories  = Category::select('id', 'name')->where('is_active', 1)->get();
    }
    public function render()
    {
        $data['products'] = $this->rows;
//        dd( $data['products']);
        return $this->view('livewire.product.manage-product', $data);
    }

    public function getRowsQueryProperty()
    {
        $query = Product::query()
            ->select('id','category_id','supplier_id','supplier_id','title','image_path','is_active')
            ->with([
                'variation:id,product_id,variation_name,cogs_price,selling_price,stock_status',
                'supplier:id,name,address',
                'category:id,name'
            ])
            ->when($this->filter['product'], fn ($q, $product)  => $q->where('title', 'like', "%{$product}%"))
            ->when($this->filter['category'], fn ($q,$category) => $q->where('category_id', '=', $this->filter['category']))
            ->latest();

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function search()
    {
        $this->hideOffCanvas();
        $this->resetPage();

        return $this->rows;
    }

    public function resetSearch()
    {
        $this->reset('filter');
        $this->hideOffCanvas();
    }
}
