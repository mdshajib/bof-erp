<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariation;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductManagementService
{
     public function updateInfo($product_info)
     {
        try
        {
            $product['category_id']  = $product_info['category'];
            $product['title']        = $product_info['title'];
            $product['supplier_id']  = $product_info['supplier'];
            $product['description']  = $product_info['description'];
            $product['type']         = $product_info['type'];
            return Product::where('id', $product_info['product_id'])->update($product);
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
     }

    public function updateVariation($variation_section): bool
    {
        try{
            DB::beginTransaction();
            foreach ($variation_section as $key => $variation){
//                $store_path = 'public'.DIRECTORY_SEPARATOR.'variations';
//                $url                               = $variation['path'] != null ? $this->imageUpload($variation['path'], $store_path) : null;
//                $variation_data['image_path']          = $url;

                $variation_data['product_id']         = $variation['product_id'];
                $variation_data['variation_name']     = $variation['variation_name'];
                $variation_data['image_path']         = $variation['path'];
                $variation_data['cogs_price']         = $variation['cogs_price'];
                $variation_data['selling_price']      = $variation['selling_price'];
                $variation_data['low_quantity_alert'] = $variation['low_quantity_alert'];
                ProductVariation::updateOrCreate([
                    'id' => $variation['id'], 'product_id' => $variation['product_id']
                ], $variation_data);
            }
            DB::commit();
            return true;
        } catch(Exception $ex){
            DB::rollBack();
            throw $ex;
        }
    }

    public function updatePrice($price_section): bool
    {
        try {
            DB::beginTransaction();
            foreach ($price_section as $key => $price){
                $price_data['cogs_price']    = $price['cogs_price'];
                $price_data['selling_price'] = $price['selling_price'];
                ProductVariation::updateOrCreate([
                    'id' =>  $price['variation_id']
                ], $price_data);
            }

            DB::commit();
            return true;
        } catch(Exception $ex){
            DB::rollBack();
            throw $ex;
        }
    }

    public function updateImage($image_section)
    {
        try {
            DB::beginTransaction();
            $store_path = 'public/'.'products';
            $url = $image_section['path'] != null ? $this->imageUpload($image_section['path'], $store_path) : null;
            Product::where('id', $image_section['product_id'])->update(['image_path' => $url]);
            DB::commit();
            return true;
        } catch(Exception $ex){
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
}
