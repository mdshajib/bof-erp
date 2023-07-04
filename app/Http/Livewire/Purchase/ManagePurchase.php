<?php

namespace App\Http\Livewire\Purchase;

use App\Http\Livewire\BaseComponent;
use App\Services\PurchaseManagementService;
use App\Traits\WithBulkActions;
use App\Traits\WithCachedRows;
use App\Traits\WithPerPagePagination;
use App\Traits\WithSorting;
use App\Models\PurchaseOrder;

class ManagePurchase extends BaseComponent
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
        return $this->view('livewire.purchase.manage-purchase', $data);
    }

    public function getRowsQueryProperty()
    {
        $query = PurchaseOrder::query()
            ->with(['user:id,first_name,last_name'])
            ->when($this->filter['purchase_number'], fn ($q, $purchase_number) => $q->where('purchase_number', 'like', "%{$purchase_number}%"));

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

    public function printBarcode($purchase_order_id)
    {
        $barcodes_url = (new PurchaseManagementService())->printPurchaseProductsBarcode($purchase_order_id);
        $this->order_report_name = url($barcodes_url);
        $this->dispatchBrowserEvent('openOrderReportPreviewModal');
    }
}
