<?php

namespace App\Http\Livewire\Purchase;

use App\Http\Livewire\BaseComponent;
use App\Services\PurchaseManagementService;

class PurchaseOrderView extends BaseComponent
{
    public $purchase_id;
    public $purchase_number;
    public $view_row_section = [];
    public $order_summary    = [];
    public $order_info       = [];

    public function mount($purchase_id)
    {
        $this->purchase_id = $purchase_id;
        $this->initDefaults($purchase_id);
    }

    public function render()
    {
        return $this->view('livewire.purchase.purchase-order-view');
    }

    private function initDefaults($purchase_id)
    {
        $purchase_order_data = (new PurchaseManagementService())->viewOrderDetails($purchase_id);
        if(count($purchase_order_data) > 0){
            $this->view_row_section = $purchase_order_data['items'];
            $this->order_summary    = $purchase_order_data['summary'];
            $this->order_info       = $purchase_order_data['order_info'];
            $this->purchase_number  = $this->order_info['purchase_number'];
        }
    }
}
