<?php

namespace App\Http\Livewire\Inventory;

use App\Http\Livewire\BaseComponent;

class ManageStock extends BaseComponent
{
    public function render()
    {
        return $this->view('livewire.inventory.manage-stock');
    }
}
