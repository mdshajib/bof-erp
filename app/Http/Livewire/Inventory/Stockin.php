<?php

namespace App\Http\Livewire\Inventory;

use App\Http\Livewire\BaseComponent;

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
        $this->sku = '';
    }
}
