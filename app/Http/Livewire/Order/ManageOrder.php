<?php

namespace App\Http\Livewire\Order;

use App\Http\Livewire\BaseComponent;
use App\Models\SalesOrder;
use App\Models\User;
use App\Services\OrderManagementService;
use App\Traits\WithBulkActions;
use App\Traits\WithCachedRows;
use App\Traits\WithPerPagePagination;
use App\Traits\WithSorting;

class ManageOrder extends BaseComponent
{
    use WithPerPagePagination;
    use WithCachedRows;
    use WithSorting;
    use WithBulkActions;

    public $order_number;
    public $filter = [
        'order_number'    => ''
    ];

    public function render()
    {
        $data['orders'] = $this->rows;
        return $this->view('livewire.order.manage-order', $data);
    }

    public function getRowsQueryProperty()
    {
        $query = SalesOrder::query()
            ->with(['user:id,first_name,last_name'])
            ->select('id','order_number','order_date','paid_amount','due_amount','gross_amount','net_payment_amount','generated_by','is_paid')
            ->when($this->filter['order_number'], fn ($q, $order_number) => $q->where('order_number', 'like', "%{$order_number}%"));

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
