<?php

namespace App\Http\Livewire\Product;

use App\Http\Livewire\BaseComponent;
use App\Models\Category;
use App\Models\Supplier;

class AddProduct extends BaseComponent
{
    public $categories;
    public $suppliers;
    public $product_info = [
        'category'     => null,
        'title'        => null,
        'supplier'     => null,
        'description'  => null,
        ];

    public function mount()
    {
        $this->categories  = Category::select('id', 'name')->where('is_active', 1)->get();
        $this->suppliers   = Supplier::select('id', 'name','address')->where('is_active', 1)->get();
    }
    public function render()
    {
        return $this->view('livewire.product.add-product');
    }
}
