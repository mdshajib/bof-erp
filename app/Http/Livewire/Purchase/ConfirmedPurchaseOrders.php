<?php

namespace App\Http\Livewire\Purchase;

use App\Http\Livewire\BaseComponent;
use App\Models\PurchaseOrder;
use App\Services\PurchaseManagementService;
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
    public $purchase_number;
    public $view_row_section = [];
    public $order_summary    = [];
    public $order_info       = [];
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

    public function markAsOpen($purchase_id)
    {
        try {
            $status = (new PurchaseManagementService())->purchaseMarkAsOpen($purchase_id);
            if($status){
                $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Purchase Order', 'message' => 'Purchase order reopen successfully' ]);
            }
        } catch(\Exception $ex){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Purchase Order', 'message' => $ex->getMessage() ]);
        }
    }

    public function generateBarcode($purchase_id)
    {
        try {
            $status = (new PurchaseManagementService())->barcodeGenerate($purchase_id);
            if($status){
                $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Barcode Generate', 'message' => 'Barcode generate successfully' ]);
            }
        } catch(\Exception $ex){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Barcode Generate', 'message' => $ex->getMessage() ]);
        }
    }

    public function OrderView($purchase_id)
    {
        $this->purchase_id = $purchase_id;

        $purchase_order_data = (new PurchaseManagementService())->viewOrderDetails($purchase_id);
        if(count($purchase_order_data) > 0){
            $this->view_row_section = $purchase_order_data['items'];
            $this->order_summary    = $purchase_order_data['summary'];
            $this->order_info       = $purchase_order_data['order_info'];
            $this->purchase_number  = $this->order_info['purchase_number'];
        }
        $this->dispatchBrowserEvent('openOrderViewModal');
    }

    public function printBarcode($purchase_order_id)
    {
        $barcodes_url = (new PurchaseManagementService())->printPurchaseProductsBarcode($purchase_order_id);
        $this->order_report_name = url($barcodes_url);
        $this->dispatchBrowserEvent('openOrderReportPreviewModal');
    }
}
