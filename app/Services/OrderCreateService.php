<?php

namespace App\Services;

use App\Models\Sku;
use Exception;

class OrderCreateService
{
    /**
     * Function details
     */
     public function skuFind($barcode)
     {
        try
        {
            $sku_with_item = Sku::query()
                ->with([
                    'variation:id,variation_name,cogs_price,selling_price,low_quantity_alert',
                    'stock:sku_id,quantity'
                ])
                ->find($barcode);
            if(! $sku_with_item){
                throw new Exception('Barcode not found!');
            }
            if( $sku_with_item->stock == null || $sku_with_item->stock?->quantity < 1){
                throw new Exception('Stock out this product!');
            }

            return $sku_with_item;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
     }

    public function variationFind($variation_id)
    {
        try
        {
            $sku_with_item = Sku::query()
                ->with([
                    'variation:id,variation_name,cogs_price,selling_price,low_quantity_alert',
                    'stock:sku_id,quantity'
                ])
                ->WhereHas('variation', function ($q) use ($variation_id) {
                    return $q->where('product_variations.id', $variation_id);
                })
                ->whereHas('stock',function ($q) {
                    return $q->where('stocks.quantity', '>', 0);
                })->first();
            if(! $sku_with_item){
                throw new Exception('Barcode not found!');
            }
            if( $sku_with_item->stock == null || $sku_with_item->stock?->quantity < 1){
                throw new Exception('Stock out this product!');
            }

            return $sku_with_item;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }
}
