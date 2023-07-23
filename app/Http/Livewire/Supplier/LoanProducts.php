<?php

namespace App\Http\Livewire\Supplier;

use App\Http\Livewire\BaseComponent;
use App\Models\Sku;
use App\Traits\WithBulkActions;
use App\Traits\WithCachedRows;
use App\Traits\WithPerPagePagination;
use App\Traits\WithSorting;

class LoanProducts extends BaseComponent
{
    use WithPerPagePagination;
    use WithCachedRows;
    use WithSorting;
    use WithBulkActions;

    public $filter = [
        'purchase_id'     => null,
    ];

    public function render()
    {
        $data['products'] = $this->rows;
        return $this->view('livewire.supplier.loan-products', $data);
    }

    public function getRowsQueryProperty()
    {
        $query = Sku::query()
            ->with([
                'variation:id,variation_name',
                'supplier:id,name'
            ])
            ->where('loan', 1)
            ->when($this->filter['purchase_id'], fn ($q, $purchase_id)  => $q->where('purchase_order_id', 'like', "%{$purchase_id}%"))
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
