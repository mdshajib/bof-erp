<?php

namespace App\Http\Livewire\Inventory;

use App\Http\Livewire\BaseComponent;
use App\Models\ProductVariation;
use App\Models\Transaction;
use App\Traits\WithBulkActions;
use App\Traits\WithCachedRows;
use App\Traits\WithPerPagePagination;
use App\Traits\WithSorting;

class TransactionList extends BaseComponent
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
        $data['transactions'] = $this->rows;
        return $this->view('livewire.inventory.transaction-list', $data);
    }

    public function getRowsQueryProperty()
    {
        $query = Transaction::query()
            ->select('id','variation_id','sku_id','quantity','type','is_adjust','created_by','created_at')
            ->with([
                'user:id,first_name,last_name',
                'variation:id,variation_name',
                'sku:id,selling_price,cogs_price,purchase_order_id'
            ])
            ->addSelect([
                'variation_name' => ProductVariation::select('variation_name')->whereColumn('transactions.variation_id','product_variations.id')
            ])
            ->when($this->filter['variation_name'], function ($q) {
                return $q->WhereHas('variation', function ($q) {
                    return $q->Where('variation_name', 'like', "%{$this->filter['variation_name']}%");
                });
            } )
            ->when($this->filter['sku'], fn ($q, $sku) => $q->where('sku_id', 'like', "%{$sku}%"))
            ->when($this->filter['purchase_id'], function ($q) {
                return $q->WhereHas('sku', function ($q) {
                    return $q->Where('purchase_order_id', 'like', "%{$this->filter['purchase_id']}%");
                });
            } )
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
