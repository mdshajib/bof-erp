<?php

namespace App\Http\Livewire\Inventory;

use App\Http\Livewire\BaseComponent;
use App\Services\StockManagementService;
use Exception;

class Stockin extends BaseComponent
{
    public $stock_type='add';

    public $sku;

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
                $this->sku = '';
            }
        } catch(Exception $ex){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Stock Error',  'message' => $ex->getMessage() ]);
            $this->sku = '';
        }
    }

    public function transactionList()
    {
        return  (new StockManagementService())->todaysTransaction();
    }
}
