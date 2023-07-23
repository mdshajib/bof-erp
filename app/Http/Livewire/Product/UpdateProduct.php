<?php

namespace App\Http\Livewire\Product;

use App\Http\Livewire\BaseComponent;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Services\ProductManagementService;
use App\Services\ProductPriceCalculation;
use Livewire\WithFileUploads;
use Exception;

class UpdateProduct extends BaseComponent
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
    public $product;
    public function mount($product_id)
    {
        $this->initProduct();
        $this->product_id       = $product_id;
    }

    public function render()
    {
        $this->categories  = Category::select('id', 'name')->where('is_active', 1)->get();
        $this->suppliers   = Supplier::select('id', 'name','address')->where('is_active', 1)->get();

        return $this->view('livewire.product.update-product',[]);
    }

    private function initProduct()
    {
        $this->product   = Product::query()->with([
            'variation'
        ])->find($this->product_id);

        $this->initProductInfo();
        $this->initVariation();
        $this->initImages();
    }

    private function initProductInfo()
    {
        $this->product_info = [
            'product_id'   => $this->product?->id,
            'category'     => $this->product?->category_id,
            'title'        => $this->product?->title,
            'supplier'     => $this->product?->supplier_id,
            'description'  => $this->product?->description,
            'type'         => $this->product?->type,
            'path'         => $this->product?->image_path,
        ];
    }

    public function initVariation()
    {
        $this->variation_section = [];

        if(count($this->product->variation) > 0){
            foreach ($this->product->variation as $variation){
                $variation_data = null;
                $variation_data = [
                    'id'                  => $variation?->id,
                    'product_id'          => $variation?->product_id,
                    'variation_name'      => $variation?->variation_name,
                    'low_quantity_alert'  => $variation?->low_quantity_alert,
                    'path'                => $variation?->image_path,
                    'cogs_price'          => $variation?->cogs_price,
                    'selling_price'       => $variation?->selling_price,
                ];

                $this->variation_section[] = $variation_data;
            }
        }
    }

    public function addVariationSection()
    {
        $variation = [
            'id'                  => 0,
            'product_id'          => $this->product_id,
            'variation_name'      => $this->product_info['title'],
            'low_quantity_alert'  => 5,
            'path'                => null,
            'cogs_price'          => 0,
            'selling_price'       => 0,
        ];

        $this->variation_section[] = $variation;
    }

    private function initPrices()
    {
        $this->price_section = [];
        foreach ($this->variation_section as $key => $variation) {
            $data['variation_id']                            = $variation['id'];
            $data['variation_name']                          = $variation['variation_name'];
            $data['cogs_price']                              = $variation['cogs_price'];
            $data['selling_price']                           = $variation['selling_price'];

            $this->price_section[] = $data;
        }
    }

    public function UpdateInfoSubmit()
    {
        try {
            $rules = [
                'product_info.category' => 'required',
                'product_info.title' => 'required',
                'product_info.supplier' => 'required',
            ];
            $messages = [
                'product_info.category.required' => 'Category required',
                'product_info.title.required' => 'Title field is required',
                'product_info.supplier.required' => 'Supplier field is required',
            ];
            $this->validate($rules, $messages);

            $status = (new ProductManagementService())->updateInfo($this->product_info);
            if($status){
                $this->currentStep = 2;
                $this->progress = '50%';
                $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Product', 'message' => 'Product basic info update successfully']);
            }
        }
        catch (Exception $ex){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Product', 'message' => $ex->getMessage() ]);
        }
    }

    private function initImages()
    {
        $this->image_section = [
            'id'            => 0,
            'product_id'    => $this->product_id,
            'path'          => null,
        ];
    }

    public function UpdateVariationSubmit()
    {
        try {
            $rules = [
                'variation_section.*.low_quantity_alert'    => 'required|numeric|gt:0',
            ];

            $this->validate($rules);
            $status = (new ProductManagementService())->updateVariation($this->variation_section);
            if ($status) {
                $this->currentStep = 3;
                $this->progress = '75%';
                $this->initPrices();
                $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Product', 'message' => 'Product variation update successfully']);
            }
        }
        catch (Exception $ex){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Product', 'message' => $ex->getMessage() ]);
        }
    }

    public function updated($name, $value)
    {
        $fields = explode('.', $name);

        if(count($fields) > 2) {
            $key          = $fields[1];
            if ($fields[2] == 'cogs_price') {
                $selling_price = (new ProductPriceCalculation())->makePrice($value);
                $this->price_section[$key]['selling_price'] = $selling_price;
            }
        }
    }

    public function UpdatePriceSubmit()
    {
        try {
            $rules = [
                'price_section.*.cogs_price'    => 'required|numeric|gt:0',
                'price_section.*.selling_price' => 'required|numeric|gt:0',
            ];
            $this->validate($rules);
            $status = (new ProductManagementService())->updatePrice($this->price_section);
            if ($status) {
                $this->currentStep = 4;
                $this->progress = '100%';
                $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Product', 'message' => 'Product price update successfully']);
            }
        }catch(Exception $ex){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Product', 'message' => $ex->getMessage() ]);
        }
    }

    public function updateMediaSubmit()
    {
        try {
            if ($this->image_section['path'] != null) {
                $status = (new ProductManagementService())->updateImage($this->image_section);
                if ($status) {
                    $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Product', 'message' => 'Product Image update successfully']);
                }
            }
        }catch(Exception $ex){
            $this->dispatchBrowserEvent('notify', ['type' => 'error', 'title' => 'Product', 'message' => $ex->getMessage() ]);
        }
    }

    public function stepSet($step)
    {
        if ($step == 1) {
            $this->currentStep = 1;
            $this->progress    = '25%';
        } elseif ($step == 2) {
            $this->initVariation();
            $this->currentStep = 2;
            $this->progress    = '50%';
        } elseif ($step == 3) {
            $this->initPrices();
            $this->currentStep = 3;
            $this->progress    = '75%';
        } elseif ($step == 4) {
            $this->initImages();
            $this->currentStep = 4;
            $this->progress    = '100%';
        }
    }

    public function previous($step)
    {
        $this->currentStep = $step;

        if ($step == 1) {
            $this->progress = '25%';
        } elseif ($step == 2) {
            $this->initVariation();
            $this->progress = '50%';
        } elseif ($step == 3) {
            $this->initPrices();
            $this->progress = '75%';
        } elseif ($step == 4) {
            $this->progress = '100%';
        } else {
            $this->progress = '25%';
        }
    }
}
