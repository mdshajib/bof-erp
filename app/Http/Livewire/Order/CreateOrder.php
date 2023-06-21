<?php

namespace App\Http\Livewire\Order;

use App\Http\Livewire\BaseComponent;

class CreateOrder extends BaseComponent
{
    public $phone;

    public $order_note;

    public $barcode;

    public $product_name;

    public $internal_comments;

    public $customer_name;
    public $payment_method = 'cash';

    public $paid_amount = null;

    public $row_section = [];

    public function mount()
    {
        $this->initDefaults();
    }

    public function render()
    {
        return $this->view('livewire.order.create-order');
    }

    private function initDefaults()
    {
        $this->row_section = [
//            [
//            'id'             => 0,
//            'product'        => 'Product Name',
//            'variant_id'     => null,
//            'sku'            => null,
//            'quantity'       => null,
//            'unit_price'     => null,
//            'discount'       => null,
//            'total_discount' => null,
//            'total'          => 22,
//        ]
        ];
    }

    public function addRow()
    {
        $row_section = [
            'id'             => 0,
            'product'        => 'Product Name',
            'variant_id'     => null,
            'sku'            => null,
            'quantity'       => null,
            'unit_price'     => null,
            'discount'       => null,
            'total_discount' => null,
            'total'          => 222,
        ];
        $this->row_section[] = $row_section;
    }

    public function saveOrder()
    {

    }

    public function removeRow($index)
    {
        if (count($this->row_section) > 1) {
            unset($this->row_section[$index]);
            // calculate again total, discount
        }
    }
}
