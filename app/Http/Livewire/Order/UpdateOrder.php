<?php

namespace App\Http\Livewire\Order;

use App\Http\Livewire\BaseComponent;
use App\Services\OrderCreateService;
use App\Services\OrderManagementService;
use App\Services\ThermalPrintService;

class UpdateOrder extends BaseComponent
{
    public $phone;
    public $order_note;
    public $order_id;
    public $internal_comments;
    public $name = null;
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

        $this->row_section       =  $exist_order['items'];
        $this->paid_amount       = $exist_order['order_info']['paid_amount'];
        $this->phone             = $exist_order['order_info']['customer_phone'];
        $this->name              = $exist_order['order_info']['customer_name'];
        $this->internal_comments = $exist_order['order_info']['internal_comments'];
        $this->order_note        = $exist_order['order_info']['order_notes'];
        $this->payment_method    = $exist_order['order_info']['payment_method'];
        $this->summaryTable();
    }

    public function updatedPaidAmount($value)
    {
        $this->summaryTable();
    }

    public function saveOrder()
    {
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
            $order_payload['order_id']        = $this->order_id;
            $order_payload['paid_amount']     = $this->paid_amount;
            $order_payload['payment_method']  = $this->payment_method;
            $status = ( new OrderCreateService())->updateOrder($order_payload);
            if($status){
                (new ThermalPrintService())->print($status);
                $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Order', 'message' => 'Update order has been completed']);
            }
            return redirect()->route('order.manage');
        } catch (\Exception $ex) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Error', 'message' => $ex->getMessage() ]);
        }
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

    public function orderCancelModal()
    {

    }
}
