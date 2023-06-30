<?php

namespace App\Http\Livewire\Purchase;

use App\Http\Livewire\BaseComponent;

class CreatePurchaseOrder extends BaseComponent
{
    public $purchase_order_summary = [];
    public $product_name;
    public $product_list   = [];
    public $order_summary  = [];

    public function mount()
    {
        $this->initDefaultsSummary();
    }

    public function render()
    {
        return $this->view('livewire.purchase.create-purchase-order');
    }

    private function initDefaultsSummary()
    {
        $this->purchase_order_summary = [
            'sub_total'       => 0,
            'total_discount'  => 0,
            'net_amount'      => 0,
            'due'             => 0,
        ];

    }
}
