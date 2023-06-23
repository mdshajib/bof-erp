<?php

namespace App\Http\Livewire\Order;

use App\Http\Livewire\BaseComponent;
use App\Services\OrderCreateService;
use Exception;

class CreateOrder extends BaseComponent
{
    public $phone;

    public $order_note;

    public $barcode;
    public $product_name;
    public $internal_comments;
    public $customer_name;
    public $product_list   = [];
    public $payment_method = 'cash';
    public $paid_amount    = 0;
    public $row_section    = [];
    public $order_summary  = [];

    protected $listeners = ['orderConfirmEvent' => 'orderConfirm', 'orderCancelEvent'=> 'orderCancel'];

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
        $this->order_summary = [
            'sub_total'       => 0,
            'total_discount'  => 0,
            'net_amount'      => 0,
            'due'             => 0,
        ];

    }

    public function addRow($sku_with_item)
    {

        if (array_search($sku_with_item->variation->id, array_column($this->row_section, 'variant_id')) !== FALSE) {
            $this->dispatchBrowserEvent('notify', ['type' => 'warning', 'title' => 'Cart Warning', 'message' => 'This Product Already added in cart!!' ]);
            $this->barcode      = null;
            $this->product_name = null;
        }
        else {
            $row_section = [
                'id'             => 0,
                'product'        => $sku_with_item->variation->variation_name,
                'variant_id'     => $sku_with_item->variation->id,
                'sku'            => $sku_with_item->id,
                'quantity'       => 1,
                'stock'          => $sku_with_item->stock->quantity - 1,
                'unit_price'     => $sku_with_item->variation->selling_price,
                'discount'       => 0,
                'total_discount' => 0,
                'total'          => $sku_with_item->variation->selling_price,
            ];
            $this->row_section[] = $row_section;
            $this->barcode       = null;
            $this->product_name  = null;
        }
        $this->summaryTable();
    }

    public function readBarcode()
    {
        try {
            $sku_with_item = (new OrderCreateService())->skuFind($this->barcode);
            if( $sku_with_item->stock->quantity <= $sku_with_item->variation->low_quantity_alert){
                $this->dispatchBrowserEvent('notify', ['type' => 'warning', 'title' => 'Stock Alert', 'message' => 'Limited stock, available quantity: '.$item->stock->quantity ]);
            }
            $this->addRow($sku_with_item);

        }catch(Exception $ex){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Error', 'message' => $ex->getMessage() ]);
        }

    }
    public function updating($name, $value)
    {
        $fields = explode('.', $name);
        if(count($fields) > 1) {
            $key = $fields[1];
            if ($fields[2] == 'quantity') {
                if ($value > $this->row_section[$key]['stock']) {
                    $this->dispatchBrowserEvent('notify', ['type' => 'warning', 'title' => 'Stock Alert', 'message' => "Can't add more than: " . $this->row_section[$key]['stock']]);
                }
            }
        }
    }

    public function updated($name, $value)
    {
        $fields = explode('.', $name);

        if(count($fields) > 1) {
            $key          = $fields[1];
            if ($fields[2] == 'quantity') {
                if ($this->row_section[$key]['quantity'] < 1) {
                    $this->row_section[$key]['quantity'] = 1;
                }
                if ($value > $this->row_section[$key]['stock']) {
                    $this->row_section[$key]['quantity']   = $this->row_section[$key]['stock'];
                }
                $this->row_section[$key]['total']          = $this->row_section[$key]['quantity'] * $this->row_section[$key]['unit_price'];
                $this->row_section[$key]['total_discount'] = $this->row_section[$key]['quantity'] * $this->row_section[$key]['discount'];
                $this->summaryTable();
            }
        }
    }

    public function updatedPaidAmount($value)
    {
        $this->summaryTable();
    }

    public function summaryTable()
    {
        foreach ($this->row_section as $item){
            $this->order_summary['sub_total']      = $item['unit_price'] * $item['quantity'];
            $this->order_summary['total_discount'] = $item['discount'] * $item['quantity'];
            $this->order_summary['net_amount']     = $this->order_summary['sub_total']  - $this->order_summary['total_discount'];
            $this->order_summary['due']            = $this->order_summary['net_amount'] - $this->paid_amount;
        }
    }

    public function saveOrder()
    {
        $rules = [
            'row_section.*.quantity'   => 'required|numeric|min:1',
            'row_section.*.unit_price' => 'required',
        ];
        $messages=[
            'row_section.*.quantity.required'   => 'Quantity required',
            'row_section.*.quantity.min'        => 'Quantity should be greater than 0',
            'row_section.*.unit_price.required' => 'Unit price required',
        ];

        $this->validate($rules, $messages);

        if( $this->order_summary['due'] > 0){
            $this->dispatchBrowserEvent('show-due-order-submission');
        }else{
            $this->orderConfirm();
        }
    }

    public function orderConfirm()
    {
        try {
           $order_payload['items']             = $this->row_section;
           $order_payload['phone']             = $this->phone;
           $order_payload['customer_name']     = $this->customer_name;
           $order_payload['paid_amount']       = $this->paid_amount;
           $order_payload['payment_method']    = $this->payment_method;
           $order_payload['order_note']        = $this->order_note;
           $order_payload['internal_comments'] = $this->internal_comments;
           $order_payload['order_summary']     = $this->order_summary;

            $status = ( new OrderCreateService())->storeOrder($order_payload);

        }catch(Exception $ex){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Error', 'message' => $ex->getMessage() ]);
        }
    }
    public function orderCancel()
    {
        //
    }

    public function updatedProductName($value)
    {
        if (strlen($this->product_name) > 2) {
            $this->product_list = (new OrderCreateService())->productSuggestions($value);
        }
        else {
            $this->product_list = [];
        }
    }

    public function getProductInfo($variant_id)
    {
        try {
            $sku_with_item = (new OrderCreateService())->variationFind($variant_id);
            if( $sku_with_item->stock->quantity <= $sku_with_item->variation->low_quantity_alert){
                $this->dispatchBrowserEvent('notify', ['type' => 'warning', 'title' => 'Stock Alert', 'message' => 'Limited stock, available quantity: '.$item->stock->quantity ]);
            }
            $this->addRow($sku_with_item);
            $this->product_list = [];

        }catch(Exception $ex){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Error', 'message' => $ex->getMessage() ]);
        }
    }

    public function removeRow($index)
    {
        if (count($this->row_section) > 1) {
            unset($this->row_section[$index]);
            // calculate again total, discount
        }
    }
}
