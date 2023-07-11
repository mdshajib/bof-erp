<?php

namespace App\Http\Livewire\Purchase;

use App\Http\Livewire\BaseComponent;
use App\Models\PurchaseOrder;
use App\Traits\WithBulkActions;
use App\Traits\WithCachedRows;
use App\Traits\WithPerPagePagination;
use App\Traits\WithSorting;

class ConfirmedPurchaseOrders extends BaseComponent
{
    use WithPerPagePagination;
    use WithCachedRows;
    use WithSorting;
    use WithBulkActions;

    public $purchase_id;
    public $order_report_name;
    public $filter = [
        'purchase_number'    => null
    ];

    public function render()
    {
        $data['orders'] = $this->rows;
        return $this->view('livewire.purchase.confirmed-purchase-orders', $data);
    }

    public function getRowsQueryProperty()
    {
        $query = PurchaseOrder::query()
            ->with(['user:id,first_name,last_name'])
            ->when($this->filter['purchase_number'], fn ($q, $purchase_number) => $q->where('purchase_number', 'like', "%{$purchase_number}%"))
            ->where([
                'is_print' => 1,'is_confirmed' => 1, 'price_updated' => 1
            ]);

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
