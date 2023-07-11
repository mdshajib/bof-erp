<?php

namespace App\Http\Livewire\Product;

use App\Http\Livewire\BaseComponent;
use App\Models\Category;
use App\Models\Supplier;
use App\Services\ProductCreateService;
use Exception;
use Livewire\WithFileUploads;

class AddProduct extends BaseComponent
{
    use WithFileUploads;

    public $categories;
    public $suppliers;
    public $currentStep = 1;
    public $progress = '25%';
    public $price_section = [];
    public $image_section = [];
    public $variation_section = [];
    public $product_id;

    public $product_info = [
        'category'     => null,
        'title'        => null,
        'supplier'     => null,
        'description'  => null,
        'path'         => null,
        'type'         => 'finished-product',
        ];

    public function mount()
    {
        $this->initDefaults();
        $this->categories  = Category::select('id', 'name')->where('is_active', 1)->get();
        $this->suppliers   = Supplier::select('id', 'name','address')->where('is_active', 1)->get();
    }
    public function render()
    {
        return $this->view('livewire.product.add-product');
    }

    private function initDefaults()
    {
        $variation = [
            'id'                  => 0,
            'variation_name'      => null,
            'low_quantity_alert'  => 5,
            'path'                => null
        ];

        $this->variation_section[] = $variation;

        $this->image_section = [
            'id'            => 0,
            'path'          => null,
        ];
        $this->product_info = [
            'category'     => null,
            'title'        => null,
            'supplier'     => null,
            'description'  => null,
            'path'         => null,
        ];
        $this->price_section = [];

    }

    public function productInfoSubmit()
    {
        try {
            $rules = [
                'product_info.category'  => 'required',
                'product_info.title'     => 'required',
                'product_info.supplier'  => 'required',
            ];
            $messages = [
                'product_info.category.required'  => 'Category required',
                'product_info.title.required'     => 'Title field is required',
                'product_info.supplier.required'  => 'Supplier field is required',
            ];
            $this->validate($rules, $messages);

            $this->currentStep = 2;
            $this->progress    = '50%';
        } catch (Exception $ex) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Product Info', 'message' => $ex->getMessage() ]);
        }
    }



    public function addVariationSection()
    {
        $variation = [
                'id'                  => 0,
                'variation_name'      => null,
                'low_quantity_alert'  => 5,
                'path'                => null
        ];

        $this->variation_section[] = $variation;
    }

    public function productVariationSubmit()
    {
        try {
            $rules = [
                'variation_section.*.low_quantity_alert'    => 'required',
            ];

            $this->validate($rules);
            $this->initPrices();
            $this->currentStep = 3;
            $this->progress    = '75%';
        } catch (Exception $ex) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Product Variation', 'message' => $ex->getMessage()]);
        }
    }

    private function initPrices()
    {
        $this->price_section = [];
        foreach ($this->variation_section as $key => $variation) {
            $data['variation_id']                            = 0;
            $data['variation_name']                          = $this->createVariationName($variation);
            $this->variation_section[$key]['variation_name'] = $data['variation_name'];
            $data['cogs_price']                              = 0;
            $data['selling_price']                           = 0;

            $this->price_section[] = $data;
        }
    }

    private function createVariationName($variant) : string
    {
        $variant_name = $this->product_info['title'];

        return $variant_name;
    }

    public function productPriceSubmit()
    {
        try {
                $rules = [
                    'price_section.*.cogs_price'     => 'required',
                    "price_section.*.selling_price"  => 'required',
                ];

                $this->validate($rules);

            $this->currentStep = 4;
            $this->progress    = '100%';

        } catch (Exception $ex) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Product Price', 'message' => $ex->getMessage() ]);
        }
    }

    public function productMediaSubmit()
    {
        try {
            $rules = [
                'image_section.path' => 'sometimes|required|max:2048|dimensions:max_width=2000,max_height=2000,min_width=200,min_height=200',
            ];

            $this->validate($rules);
            $status = (new ProductCreateService())->createProduct($this->product_info, $this->variation_section, $this->price_section, $this->image_section);
            if($status) {
                $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Active', 'message' => 'Product create successfully']);
            }
            $this->initDefaults();
            $this->currentStep = 1;
            $this->progress = '25%';
        } catch (Exception $ex) {
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Product Price', 'message' => $ex->getMessage() ]);
        }
    }

    public function removeVariationSection($index, $variant_id = 0)
    {
        if (count($this->variation_section) > 1) {
            unset($this->variation_section[$index]);
        }
    }

    public function previous($step)
    {
        $this->currentStep = $step;

        if ($step == 1) {
            $this->progress = '25%';
        } elseif ($step == 2) {
            $this->progress = '50%';
        } elseif ($step == 3) {
            $this->progress = '75%';
        } elseif ($step == 4) {
            $this->progress = '100%';
        } else {
            $this->progress = '25%';
        }
    }

    public function stepSet($step)
    {
        if ($step==1) {
            $this->currentStep = 1;
            $this->progress    = '25%';
        } elseif ($step==2) {
            $this->currentStep = 2;
            $this->progress    = '50%';
        } elseif ($step==3) {
            $this->currentStep = 3;
            $this->progress    = '75%';
        } elseif ($step==4) {
            $this->currentStep = 4;
            $this->progress    = '100%';
        }
    }
}
