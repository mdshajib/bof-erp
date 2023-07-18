<?php

namespace App\Http\Livewire\Order;

use App\Http\Livewire\BaseComponent;
use App\Services\OrderCreateService;
use App\Services\ThermalPrintService;
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

    protected $listeners = ['orderConfirmEvent' => 'orderConfirm', 'orderCancelModalEvent'=> 'orderCancelModal'];

    public function mount()
    {
        $this->initDefaultsSummary();
    }

    public function render()
    {
        return $this->view('livewire.order.create-order');
    }

    private function initDefaultsSummary()
    {
        $this->order_summary = [
            'sub_total'       => 0,
            'total_discount'  => 0,
            'net_amount'      => 0,
            'due'             => 0,
        ];

    }

    private function initDefaults()
    {
        $this->row_section      = [];
        $this->paid_amount       = 0;
        $this->phone             = null;
        $this->customer_name     = null;
        $this->internal_comments = null;
        $this->order_note        = null;
        $this->payment_method    = 'cash';
        $this->initDefaultsSummary();

    }

    public function addRow($sku_with_item)
    {
        $key = array_search($sku_with_item->variation->id, array_column($this->row_section, 'variation_id'));

        if($key === FALSE){
            $row_section = [
                'id'                  => 0,
                'outlet_id'           => auth()->user()->outlet_id,
                'product'             => $sku_with_item->variation->variation_name,
                'product_id'          => $sku_with_item->product_id,
                'variation_id'        => $sku_with_item->variation_id,
                'sku_id'              => $sku_with_item->id,
                'quantity'            => 1,
                'stock'               => $sku_with_item->stock->quantity,
                'unit_price'          => $sku_with_item->selling_price,
                'discount'            => 0,
                'applied_discount_id' => null,
                'total_discount'      => 0,
                'gross_amount'        => $sku_with_item->selling_price,
                'total_sales_price'   => $sku_with_item->selling_price,
            ];
            $this->row_section[]      = $row_section;
            $this->barcode            = null;
            $this->product_name       = null;
            $this->summaryTable();
        }
        else {
             $this->row_section[$key]['quantity'] += 1;
            $this->barcode            = null;
            $this->product_name       = null;
            $this->checkQuantityStock($this->row_section[$key]['quantity'], $key);
        }
    }

    public function readBarcode()
    {
        try {
            $sku_with_item = (new OrderCreateService())->skuFind($this->barcode);
            if( $sku_with_item->stock->quantity <= $sku_with_item->variation->low_quantity_alert){
                $this->dispatchBrowserEvent('notify', ['type' => 'warning', 'title' => 'Stock Alert', 'message' => 'Stock limited, available quantity: '.$sku_with_item->stock->quantity ]);
            }
            $this->addRow($sku_with_item);

        }catch(Exception $ex){
            $this->barcode      = null;
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

    private function checkQuantityStock($value, $key)
    {
        if ($this->row_section[$key]['quantity'] < 1) {
            $this->row_section[$key]['quantity'] = 1;
        }
        if ($value > $this->row_section[$key]['stock']) {
            $this->row_section[$key]['quantity']      = $this->row_section[$key]['stock'];
        }
        $this->row_section[$key]['gross_amount']      = $this->row_section[$key]['quantity'] * $this->row_section[$key]['unit_price'];
        $this->row_section[$key]['total_discount']    = $this->row_section[$key]['quantity'] * $this->row_section[$key]['discount'];
        $this->row_section[$key]['total_sales_price'] = $this->row_section[$key]['gross_amount'] - $this->row_section[$key]['total_discount'];
        $this->summaryTable();
    }

    public function updated($name, $value)
    {
        $fields = explode('.', $name);

        if(count($fields) > 1) {
            $key          = $fields[1];
            if ($fields[2] == 'quantity') {
                $this->checkQuantityStock($value, $key);
            }
        }
    }

    public function updatedPaidAmount($value)
    {
        $this->summaryTable();
    }

    public function summaryTable()
    {
        $this->initDefaultsSummary();
        foreach ($this->row_section as $item){
            $this->order_summary['sub_total']      += $item['quantity'] * $item['unit_price'];
            $this->order_summary['total_discount'] += $item['quantity'] * $item['discount'];
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

        if(count($this->row_section) < 1){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Empty Cart', 'message' => 'Cart is empty. Please add products']);
            return false;
        }

        if( $this->order_summary['due'] > 0){
            $this->dispatchBrowserEvent('show-due-order-submission');
        }else{
            $this->orderConfirm();
        }
        return true;
    }

    public function orderConfirm()
    {
        try {
           $order_payload['items']             = $this->row_section;
           $order_payload['outlet_id']         = auth()->user()->outlet_id;
           $order_payload['phone']             = $this->phone;
           $order_payload['customer_name']     = $this->customer_name;
           $order_payload['paid_amount']       = $this->paid_amount;
           $order_payload['payment_method']    = $this->payment_method;
           $order_payload['order_note']        = $this->order_note;
           $order_payload['internal_comments'] = $this->internal_comments;
           $order_payload['order_summary']     = $this->order_summary;

            $status = ( new OrderCreateService())->storeOrder($order_payload);
            if($status){
                (new ThermalPrintService())->print($status);
                $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Order', 'message' => 'New order has been completed']);
                $this->initDefaults();
            }

        }catch(Exception $ex){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Error', 'message' => $ex->getMessage() ]);
        }
    }
    public function orderCancel()
    {
        $this->initDefaults();
    }

    public function orderCancelModal()
    {

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
                $this->dispatchBrowserEvent('notify', ['type' => 'warning', 'title' => 'Stock Alert', 'message' => 'Limited stock, available quantity: '.$sku_with_item->stock->quantity ]);
            }
            $this->addRow($sku_with_item);
            $this->product_list = [];

        }catch(Exception $ex){
            $this->product_name = null;
            $this->product_list = [];
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Error', 'message' => $ex->getMessage() ]);
        }
    }

    public function removeRow($index)
    {
        if (count($this->row_section) > 0) {
            unset($this->row_section[$index]);
            $this->row_section = array_values($this->row_section);
            $this->summaryTable();
        }
    }
}
