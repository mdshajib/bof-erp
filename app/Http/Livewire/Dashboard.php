<?php

namespace App\Http\Livewire;

use App\Http\Livewire\BaseComponent;

class Dashboard extends BaseComponent
{
    public function render()
    {
        return $this->view('livewire.dashboard');
    }
}
