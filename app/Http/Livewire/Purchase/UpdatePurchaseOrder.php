<?php

namespace App\Http\Livewire\Purchase;

use App\Http\Livewire\BaseComponent;
use App\Services\OrderCreateService;
use App\Services\PurchaseCreateService;
use App\Services\PurchaseUpdateService;

class UpdatePurchaseOrder extends BaseComponent
{
    public $purchase_order_summary = [];
    public $product_name;
    public $purchase_id;
    public $confirmed = false;
    public $internal_comments;
    public $product_list   = [];
    public $row_section    = [];
    public $purchase_item_id_to_delete = [];

    public function mount($purchase_id)
    {
        $this->purchase_id = $purchase_id;
        $this->initDefaults($purchase_id);
    }

    public function render()
    {
        return $this->view('livewire.purchase.update-purchase-order',[]);
    }

    private function initDefaultsSummary()
    {
        $this->purchase_order_summary = [
            'sub_total'          => 0,
            'net_payment_amount' => 0,
        ];
    }

    private function initDefaults($purchase_id)
    {
        $purchase_data = (new PurchaseUpdateService())->purchaseOrder($purchase_id);
        $this->row_section       = $purchase_data['items'];
        $this->internal_comments = $purchase_data['order_info']['internal_comments'];
        $this->purchase_order_summary = [
            'sub_total'          => $purchase_data['summary']['sub_total'],
            'net_payment_amount' => 0,
        ];
    }

    public function updated($name, $value)
    {
        $fields = explode('.', $name);

        if(count($fields) > 1) {
            $key          = $fields[1];
            if ($fields[2] == 'quantity') {
                $this->quantityCalculate($value, $key);
            }
            elseif ($fields[2] == 'cogs_price') {
                $this->calculatePrice($value, $key);
            }
        }
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

    private function quantityCalculate($value, $key)
    {
        if ($this->row_section[$key]['quantity'] < 1) {
            $this->row_section[$key]['quantity'] = 1;
        }

        $this->row_section[$key]['gross_amount'] = $this->row_section[$key]['quantity'] * $this->row_section[$key]['cogs_price'];
        $this->summaryTable();
    }

    private function calculatePrice($value, $key)
    {
        $this->row_section[$key]['gross_amount'] = $this->row_section[$key]['quantity'] * $this->row_section[$key]['cogs_price'];
        $this->summaryTable();
    }

    public function getProductInfo($variant_id)
    {
        try {
            $variation = (new PurchaseCreateService())->variationFind($variant_id);
            $this->addRow($variation);
            $this->product_name = null;
            $this->product_list = [];

        }catch(Exception $ex){
            $this->product_name = null;
            $this->product_list = [];
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Error', 'message' => $ex->getMessage() ]);
        }
    }

    private function addRow($variation)
    {
        $key = array_search($variation->id, array_column($this->row_section, 'variation_id'));

        if($key === FALSE){
            $row_section = [
                'id'                  => 0,
                'product'             => $variation->variation_name,
                'product_id'          => $variation->product_id,
                'supplier'            => $variation->product?->supplier?->name,
                'variation_id'        => $variation->id,
                'quantity'            => 1,
                'selling_price'       => $variation->selling_price,
                'cogs_price'          => $variation->cogs_price,
                'gross_amount'        => $variation->cogs_price,
            ];
            $this->row_section[]      = $row_section;
        }
        else {
            $this->row_section[$key]['quantity'] += 1;
            $this->row_section[$key]['gross_amount'] = $this->row_section[$key]['quantity'] * $this->row_section[$key]['cogs_price'];
        }

        $this->summaryTable();
    }

    private function summaryTable()
    {
        $this->initDefaultsSummary();
        foreach ($this->row_section as $item){
            $this->purchase_order_summary['sub_total']          += $item['quantity'] * $item['cogs_price'];
            $this->purchase_order_summary['net_payment_amount']  = $this->purchase_order_summary['sub_total'];
        }
    }

    public function removeRow($index, $item_id = 0)
    {
        if ($item_id > 0) {
            $this->purchase_item_id_to_delete[] = $item_id;
        }

        if (count($this->row_section) > 0) {
            unset($this->row_section[$index]);
            $this->row_section = array_values($this->row_section);
            $this->summaryTable();
        }
    }

    public function saveOrder()
    {
        $rules = [
            'row_section.*.quantity'   => 'required|numeric|min:1',
            'row_section.*.cogs_price' => 'required',
        ];
        $messages=[
            'row_section.*.quantity.required'   => 'Quantity required',
            'row_section.*.quantity.min'        => 'Quantity should be greater than 0',
            'row_section.*.cogs_price.required' => 'COGS price required',
        ];

        $this->validate($rules, $messages);

        if(count($this->row_section) < 1){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Empty Cart', 'message' => 'Cart is empty. Please add products']);
            return false;
        }
        $this->orderConfirm();

        return true;
    }

    public function orderConfirm()
    {
        try {
            $order_payload['items']             = $this->row_section;
            $order_payload['internal_comments'] = $this->internal_comments;
            $order_payload['amount_confirmed']  = $this->confirmed;
            $order_payload['order_summary']     = $this->purchase_order_summary;
            $order_payload['delete_item_ids']   = $this->purchase_item_id_to_delete;

            $status = ( new PurchaseUpdateService())->purchaseUpdate($this->purchase_id, $order_payload);
            if($status){
                $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Order', 'message' => 'New order has been completed']);
                return redirect()->route('purchase.open');
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
}
