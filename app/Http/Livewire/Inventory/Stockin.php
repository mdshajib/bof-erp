<?php

namespace App\Http\Livewire\Inventory;

use App\Http\Livewire\BaseComponent;
use App\Services\StockManagementService;
use Exception;

class Stockin extends BaseComponent
{
    public $stock_type='add';
    public $activeTab='addStock';

    public $sku;
    public $quantity = 0;
    public $note = null;

    public function render()
    {
        $data['transactions'] = $this->transactionList();
        return $this->view('livewire.inventory.stockin', $data);
    }

    public function AddStock()
    {
        try{
            $status = (new StockManagementService())->findProductBySku($this->sku, $this->stock_type);
            if($status != null) {
                $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Stock Operation', 'message' => $status]);
            }
            $this->sku = null;
        } catch(Exception $ex){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Stock Error',  'message' => $ex->getMessage() ]);
            $this->sku = null;
        }
    }
    public function adjustPlus()
    {
        try {
            $rules = [
                'quantity'  => 'required|numeric|gt:0',
                'note'      => 'required',
            ];

            $this->validate($rules);
            $status = (new StockManagementService())->stockPlus($this->sku, $this->quantity, $this->note);
            if($status != null) {
                $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Stock Operation', 'message' => $status]);
                $this->note     = null;
                $this->sku      = null;
                $this->quantity = 0;
            }
        } catch (Exception $ex) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Stock Error', 'message' => $ex->getMessage()]);
        }
    }

    public function adjustMinus()
    {
        try {
            $rules = [
                'quantity'  => 'required|numeric|gt:0',
                'note'      => 'required',
            ];

            $this->validate($rules);
            $status = (new StockManagementService())->stockMinus($this->sku, $this->quantity, $this->note);
            if($status != null) {
                $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Stock Operation', 'message' => $status]);
                $this->note     = null;
                $this->sku      = null;
                $this->quantity = 0;
            }
        } catch (Exception $ex) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Stock Error', 'message' => $ex->getMessage()]);
        }
    }

    public function transactionList()
    {
        return  (new StockManagementService())->todaysTransaction();
    }

    public function stepActive($step)
    {
        if ($step == 1) {
            $this->activeTab='addStock';
            $this->stock_type = 'add';
        } elseif ($step == 2) {
            $this->activeTab='adjustPlus';
            $this->stock_type = 'adjust_plus';
        }elseif ($step == 3) {
            $this->activeTab='adjustMinus';
            $this->stock_type = 'adjust_minus';
        }
    }
}
