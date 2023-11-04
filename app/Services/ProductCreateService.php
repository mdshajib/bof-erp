<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariation;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class ProductCreateService
{
    private $product_id;
    use WithFileUploads;
     public function createProduct($product_info, $variation_section, $price_section, $image_section)
     {
        try
        {
            DB::beginTransaction();
            try {
                $product                     = new Product();
                $product->title              = trim($product_info['title']);
                $product->category_id        = trim($product_info['category']);
                $product->supplier_id        = trim($product_info['supplier']);
                $product->type               = trim($product_info['type']);
                $product->description        = trim($product_info['description']);
                $store_path                  = 'public/products';
                $url                         = $image_section['path'] != null ? $this->imageUpload($image_section['path'], $store_path) : null;
                $product->image_path         = $url;

                $product->save();

                $this->product_id = $product->id;

                //product variants save
                foreach ($variation_section as $key => $variation) {
                    $url                               = null;
                    $variant_save                      = new ProductVariation();
                    $variant_save->product_id          = $this->product_id;
                    $variant_save->variation_name      = trim($variation['variation_name']);
                    $store_path                        = 'public/variations';
                    $url                               = $variation['path'] != null ? $this->imageUpload($variation['path'], $store_path) : null;
                    $variant_save->image_path          = $url;
                    $variant_save->cogs_price          = trim($price_section[$key]['cogs_price']);
                    $variant_save->selling_price       = trim($price_section[$key]['selling_price']);
                    $variant_save->low_quantity_alert  = trim($variation['low_quantity_alert']);
                    $variant_save->save();
                }

                DB::commit();
                return true;
            } catch (Exception $ex) {
                DB::rollBack();
                throw $ex;
            }
        }
        catch(Exception $ex)
        {
            DB::rollBack();
            throw $ex;
        }
     }

     private function imageUpload($file, $path): string
     {
         try{
             $uploadedFile           = $file;
             $filename               = time() . $uploadedFile->getClientOriginalName();
             $filename               = str_replace(' ', '_', $filename);
             $url                    = Storage::disk('local')->putFileAs($path, $uploadedFile, $filename);
             return Storage::disk('local')->url($url);
         } catch(Exception $ex){
             throw $ex;
         }
    }

    public function generateColor()
    {
        return '#'.str_pad(dechex(mt_rand(0xFFFFFF / 6, 0xFFFFFF)), 2, '0', STR_PAD_LEFT);
    }
}
