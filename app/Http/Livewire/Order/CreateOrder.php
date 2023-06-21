<?php

namespace App\Http\Livewire\Order;

use App\Http\Livewire\BaseComponent;
use App\Models\ProductVariation;

class CreateOrder extends BaseComponent
{
    public $phone;

    public $order_note;

    public $barcode;

    public $product_name;

    public $internal_comments;

    public $customer_name;

    public $product_list = [];

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
            'product'        => $this->barcode,
            'variant_id'     => null,
            'sku'            => null,
            'quantity'       => null,
            'unit_price'     => null,
            'discount'       => null,
            'total_discount' => null,
            'total'          => 222,
        ];
        $this->row_section[] = $row_section;
        $this->barcode       = null;
        $this->product_name  = null;
    }

    public function saveOrder()
    {

    }

    public function updatedProductName($value)
    {
        if (strlen($this->product_name) > 2) {
            $this->product_list = ProductVariation::query()
                ->select('id', 'product_id', 'variation_name')
//                ->with('product:id,title')
                ->Where('variation_name', 'like', '%'.$value.'%')
                ->limit(10)->get();
        }
        else {
            $this->product_list = [];
        }
    }

    public function getProductInfo($variant_id)
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
