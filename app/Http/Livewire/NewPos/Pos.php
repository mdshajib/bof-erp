<?php

namespace App\Http\Livewire\NewPos;

use App\Http\Livewire\PosComponent;

class Pos extends PosComponent
{
    public $product_list = [];
    public $row_section = [];

    public function mount()
    {
        $counter = 1;
        while ($counter <12){
            $row_section = [
                'id'                  => 0,
                'outlet_id'           => 1,
                'product'             => 11,
                'product_id'          => 111,
                'variation_id'        => 12,
                'sku_id'              => 123,
                'quantity'            => 1,
                'stock'               => 6,
                'unit_price'          => 9,
            ];
            $this->row_section[] = $row_section;
            $counter++;
        }
    }
    public function render()
    {
        return $this->view('livewire.new-pos.pos' , []);
    }
}
