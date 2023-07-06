<?php

namespace App\Http\Livewire\Inventory;

use App\Http\Livewire\BaseComponent;
use App\Models\Stock;
use App\Traits\WithBulkActions;
use App\Traits\WithCachedRows;
use App\Traits\WithPerPagePagination;
use App\Traits\WithSorting;

class ManageStock extends BaseComponent
{
    use WithPerPagePagination;
    use WithCachedRows;
    use WithSorting;
    use WithBulkActions;

    public $filter = [
        'product'    => ''
    ];
    public function render()
    {
        $data['stocks'] = $this->rows;
        return $this->view('livewire.inventory.manage-stock', $data);
    }

    public function getRowsQueryProperty()
    {
        $query = Stock::query()
            ->select('outlet_id','product_id','variation_id','sku_id','quantity')
            ->with([
                'variation:id,variation_name',
                'product:id,supplier_id',
                'product.supplier:id,name,address'
            ])
            ->groupBy('sku_id')
            ->groupBy('outlet_id');

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
