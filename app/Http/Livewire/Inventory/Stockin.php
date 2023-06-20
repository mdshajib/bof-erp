<?php

namespace App\Http\Livewire\Inventory;

use App\Http\Livewire\BaseComponent;
use App\Models\Sku;

class Stockin extends BaseComponent
{
    public $stock_type='add';

    public $sku;

    public function render()
    {
        return $this->view('livewire.inventory.stockin');
    }

    public function AddStock()
    {
        $this->findProductBySku($this->sku);
    }

    public function findProductBySku($sku)
    {
        $product = Sku::query()->find($sku);
        if(! $product){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Error',  'message' => 'Sku not found']);
            $this->sku = '';
        }
    }
}
