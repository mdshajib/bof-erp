<?php

namespace App\Http\Livewire\Order;

use App\Http\Livewire\BaseComponent;
use App\Services\ContactService;
use App\Services\OrderCreateService;
use App\Services\OrderManagementService;
use App\Services\ThermalPrintService;

class UpdateOrder extends BaseComponent
{
    public $phone;

    public $order_note;

    public $order_id;
    public $barcode;
    public $is_special = false;
    public $product_name;
    public $internal_comments;
    public $name = null;
    public $product_list   = [];
    public $payment_method = 'cash';
    public $paid_amount    = 0;
    public $row_section    = [];
    public $order_summary  = [];

    protected $listeners = ['orderConfirmEvent' => 'orderConfirm', 'orderCancelModalEvent'=> 'orderCancelModal'];

    public function mount($order_id)
    {
        $this->order_id = $order_id;
        $this->initDefaults($order_id);
    }

    public function render()
    {
        return $this->view('livewire.order.update-order');
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

    private function initDefaults($order_id)
    {
        $exist_order = (new OrderManagementService())->getOrderDetails($order_id);
//        dd($exist_order);
        $this->row_section      =  $exist_order['items'];
        $this->paid_amount       = $exist_order['order_info']['paid_amount'];
        $this->phone             = $exist_order['order_info']['customer_phone'];
        $this->customer_name     = $exist_order['order_info']['customer_name'];
        $this->internal_comments = $exist_order['order_info']['internal_comments'];
        $this->order_note        = $exist_order['order_info']['order_notes'];
        $this->payment_method    = $exist_order['order_info']['payment_method'];
        $this->initDefaultsSummary();

    }

    public function updatedPaidAmount($value)
    {
        $this->summaryTable();
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
            $order_payload['name']              = $this->name;
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

    public function updatedPhone($phone)
    {
        $this->is_special = false;
        $this->name       = null;
        $contact = (new ContactService())->contactFindByPhone($phone);
        if($contact){
            $this->name = $contact->name;
        }
    }
}
