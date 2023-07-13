<?php

namespace App\Http\Livewire\Purchase;

use App\Http\Livewire\BaseComponent;
use App\Models\PurchaseOrder;
use App\Services\PurchaseManagementService;
use App\Traits\WithBulkActions;
use App\Traits\WithCachedRows;
use App\Traits\WithPerPagePagination;
use App\Traits\WithSorting;

class OpenPurchaseOrders extends BaseComponent
{
    use WithPerPagePagination;
    use WithCachedRows;
    use WithSorting;
    use WithBulkActions;

    protected $listeners = ['deleteConfirm' => 'deletePurchase', 'deleteCancel' => 'purchaseDeleteCancel'];

    public $purchase_id;
    public $purchase_number;
    public $purchaseIdBeingRemoved = null;
    public $order_report_name;
    public $view_row_section = [];
    public $order_summary    = [];
    public $order_info       = [];
    public $filter = [
        'purchase_number'    => null
    ];
    public function render()
    {
        $data['orders'] = $this->rows;
        return $this->view('livewire.purchase.open-purchase-orders', $data);
    }

    public function getRowsQueryProperty()
    {
        $query = PurchaseOrder::query()
            ->select('id','purchase_number','gross_amount','order_date','generated_by','is_print','price_updated','is_confirmed')
            ->with(['user:id,first_name,last_name'])
            ->when($this->filter['purchase_number'], fn ($q, $purchase_number) => $q->where('purchase_number', 'like', "%{$purchase_number}%"))
            ->where([
                'is_confirmed' => 0,
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

    public function confirmPurchase($purchase_id)
    {
        try{
            $status = (new PurchaseManagementService())->purchaseConfirm($purchase_id);
            if($status){
                $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Purchase Confirm', 'message' => 'Purchase order confirm successfully' ]);
            }
        } catch (\Exception $ex){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Purchase Confirm', 'message' => $ex->getMessage() ]);
        }
    }

    public function printPurchase($purchase_id)
    {
        try {
            $barcodes_url = (new PurchaseManagementService())->purchasePrint($purchase_id);
            $this->order_report_name = url($barcodes_url);
            $this->dispatchBrowserEvent('openOrderReportPreviewModal');
        } catch (\Exception $ex){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Purchase Print', 'message' => $ex->getMessage() ]);
        }
    }

    public function purchaseConfirmDelete($purchase_id)
    {
        $this->purchaseIdBeingRemoved = $purchase_id;
        $this->dispatchBrowserEvent('show-delete-notification');
    }

    public function purchaseDeleteCancel()
    {

    }

    public function deletePurchase()
    {
        try {
            $status = (new PurchaseManagementService())->purchaseDelete($this->purchaseIdBeingRemoved);
            if($status){
                $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Purchase Delete', 'message' => 'Purchase order delete successfully' ]);
            }
        } catch (\Exception $ex){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Purchase Print', 'message' => $ex->getMessage() ]);
        }
    }
}
