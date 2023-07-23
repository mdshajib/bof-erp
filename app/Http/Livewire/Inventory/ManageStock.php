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
        'variation_name' => null,
        'sku'            => null,
        'purchase_id'    => null
    ];
    public function render()
    {
        $data['stocks'] = $this->rows;
        return $this->view('livewire.inventory.manage-stock', $data);
    }

    public function getRowsQueryProperty()
    {
        $query = Stock::query()
            ->select('outlet_id','product_id','variation_id','sku_id','quantity','supplier_id')
            ->with([
                'variation:id,variation_name',
                'supplier:id,name,address',
                'sku:id,selling_price,cogs_price,purchase_order_id,loan'
            ])
            ->when($this->filter['variation_name'], function ($q) {
                return $q->WhereHas('variation', function ($q) {
                    return $q->Where('variation_name', 'like', "%{$this->filter['variation_name']}%");
                });
            })
            ->when($this->filter['purchase_id'], function ($q) {
                return $q->WhereHas('sku', function ($q) {
                    return $q->Where('purchase_order_id', 'like', "%{$this->filter['purchase_id']}%");
                });
            })
            ->when($this->filter['sku'], fn ($q, $sku) => $q->where('sku_id', 'like', "%{$sku}%"))
            ->groupBy('sku_id')
            ->groupBy('outlet_id')->latest();

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
