<?php

namespace App\Http\Livewire\Supplier;

use App\Http\Livewire\BaseComponent;
use App\Models\Sku;
use App\Services\SkuManagementService;
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
            ])->withSum([
                'transaction' => fn($q) => $q->where('type', 'out')->where('is_adjust', 1)
            ],'quantity')
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

    public function pidNow($sku)
    {
        try {
            $status = (new SkuManagementService())->paidLoanProduct($sku);
            if ($status) {
                $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Update loan', 'message' => 'Loan Paid success']);
            }
        }catch (\Exception $ex){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Update loan',  'message' => $ex->getMessage() ]);
        }
    }
}
