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
                $product->description        = trim($product_info['description']);
                $url                         = $image_section['path'] != null ? $this->imageUpload($image_section['path'], 'products') : null;
                $product->image_path         = $url;

                $product->save();

                $this->product_id = $product->id;

                //product variants save
                foreach ($variation_section as $key => $variation) {
                    $url                               = null;
                    $variant_save                      = new ProductVariation();
                    $variant_save->product_id          = $this->product_id;
                    $variant_save->variation_name      = trim($variation['variation_name']);
                    $url                               = $variation['path'] != null ? $this->imageUpload($variation['path'], 'variations') : null;
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
             $url                    = Storage::disk('public')->putFileAs($path, $uploadedFile, $filename);
             return Storage::disk('public')->url($url);
         } catch(Exception $ex){
             throw $ex;
         }
    }
}
